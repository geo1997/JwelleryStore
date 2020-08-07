d be added to Params::Util
sub _STRINGLIKE0 ($) {
    return 1 if _STRING( $_[0] );
    if ( blessed $_[0] ) {
        return overload::Method( $_[0], q{""} );
    }

    return 1 if defined $_[0] && $_[0] eq q{};

    return 0;
}

sub _reconcile_roles_for_metaclass {
    my ($class_meta_name, $super_meta_name) = @_;

    my @role_differences = _role_differences(
        $class_meta_name, $super_meta_name,
    );

    # handle the case where we need to fix compatibility between a class and
    # its parent, but all roles in the class are already also done by the
    # parent
    # see t/metaclasses/metaclass_compat_no_fixing_bug.t
    return $super_meta_name
        unless @role_differences;

    return Moose::Meta::Class->create_anon_class(
        superclasses => [$super_meta_name],
        roles        => [map { $_->name } @role_differences],
        cache        => 1,
    )->name;
}

sub _role_differences {
    my ($class_meta_name, $super_meta_name) = @_;
    my @super_role_metas
        = grep { !$_->isa('Moose::Meta::Role::Composite') }
               $super_meta_name->meta->can('calculate_all_roles_with_inheritance')
                   ? $super_meta_name->meta->calculate_all_roles_with_inheritance
                   : $super_meta_name->meta->can('calculate_all_roles')
                   ? $super_meta_name->meta->calculate_all_roles
                   : ();
    my @role_metas
        = grep { !$_->isa('Moose::Meta::Role::Composite') }
               $class_meta_name->meta->can('calculate_all_roles_with_inheritance')
                   ? $class_meta_name->meta->calculate_all_roles_with_inheritance
                   : $class_meta_name->meta->can('calculate_all_roles')
                   ? $class_meta_name->meta->calculate_all_roles
                   : ();
    my @differences;
    for my $role_meta (@role_metas) {
        push @differences, $role_meta
            unless any { $_->name eq $role_meta->name } @super_role_metas;
    }
    return @differences;
}

sub _classes_differ_by_roles_only {
    my ( $self_meta_name, $super_meta_name ) = @_;

    my $common_base_name
        = _find_common_base( $self_meta_name, $super_meta_name );

    return unless defined $common_base_name;

    my @super_meta_name_ancestor_names
        = _get_ancestors_until( $super_meta_name, $common_base_name );
    my @class_meta_name_ancestor_names
        = _get_ancestors_until( $self_meta_name, $common_base_name );

    return
        unless all { _is_role_only_subclass($_) }
        @super_meta_name_ancestor_names,
        @class_meta_name_ancestor_names;

    return 1;
}

sub _find_common_base {
    my ($meta1, $meta2) = map { Class::MOP::class_of($_) } @_;
    return unless defined $meta1 && defined $meta2;

    # FIXME? This doesn't account for multiple inheritance (not sure
    # if it needs to though). For example, if somewhere in $meta1's
    # history it inherits from both ClassA and ClassB, and $meta2
    # inherits from ClassB & ClassA, does it matter? And what crazy
    # fool would do that anyway?

    my %meta1_parents = map { $_ => 1 } $meta1->linearized_isa;

    return first { $meta1_parents{$_} } $meta2->linearized_isa;
}

sub _get_ancestors_until {
    my ($start_name, $until_name) = @_;

    my @ancestor_names;
    for my $ancestor_name (Class::MOP::class_of($start_name)->linearized_isa) {
        last if $ancestor_name eq $until_name;
        push @ancestor_names, $ancestor_name;
    }
    return @ancestor_names;
}

sub _is_role_only_subclass {
    my ($meta_name) = @_;
    my $meta = Class::MOP::Class->initialize($meta_name);
    my @parent_names = $meta->superclasses;

    # XXX: don't feel like messing with multiple inheritance here... what would
    # that even do?
    return unless @parent_names == 1;
    my ($parent_name) = @parent_names;
    my $parent_meta = Class::MOP::Class->initialize($parent_name);

    # only get the roles attached to this particular class, don't look at
    # superclasses
    my @roles = $meta->can('calculate_all_roles')
                    ? $meta->calculate_all_roles
                    : ();

    # it's obviously not a role-only subclass if it doesn't do any roles
    return unless @roles;

    # loop over all methods that are a part of the current class
    # (not inherited)
    for my $method ( $meta->_get_local_methods ) {
        # always ignore meta
        next if $method->isa('Class::MOP::Method::Meta');
        # we'll deal with attributes below
        next if $method->can('associated_attribute');
        # if the method comes from a role we consumed, ignore it
        next if $meta->can('does_role')
             && $meta->does_role($method->original_package_name);
        # FIXME - this really isn't right. Just because a modifier is
        # defined in a role doesn't mean it isn't _also_ defined in the
        # subclass.
        next if $method->isa('Class::MOP::Method::Wrapped')
             && (
                 (!scalar($method->around_modifiers)
               || any { $_->has_around_method_modifiers($method->name) } @roles)
              && (!scalar($method->before_modifiers)
               || any { $_->has_before_method_modifiers($method->name) } @roles)
              && (!scalar($method->after_modifiers)
               || any { $_->has_after_method_modifiers($method->name) } @roles)
                );

        return 0;
    }

    # loop over all attributes that are a part of the current class
    # (not inherited)
    # FIXME - this really isn't right. Just because an attribute is
    # defined in a role doesn't mean it isn't _also_ defined in the
    # subclass.
    for my $attr (map { $meta->get_attribute($_) } $meta->get_attribute_list) {
        next if any { $_->has_attribute($attr->name) } @roles;

        return 0;
    }

    return 1;
}

1;

# ABSTRACT: Utilities for working with Moose classes



=pod

=head1 NAME

Moose::Util - Utilities for working with Moose classes

=head1 VERSION

version 2.0604

=head1 SYNOPSIS

  use Moose::Util qw/find_meta does_role search_class_by_role/;

  my $meta = find_meta($object) || die "No metaclass found";

  if (does_role($object, $role)) {
    print "The object can do $role!\n";
  }

  my $class = search_class_by_role($object, 'FooRole');
  print "Nearest class with 'FooRole' is $class\n";

=head1 DESCRIPTION

This module provides a set of utility functions. Many of these
functions are intended for use in Moose itself or MooseX modules, but
some of them may be useful for use in your own code.

=head1 EXPORTED FUNCTIONS

=over 4

=item B<find_meta($class_or_obj)>

This method takes a class name or object and attempts to find a
metaclass for the class, if one exists. It will B<not> create one if it
does not yet exist.

=item B<does_role($class_or_obj, $role_or_obj)>

Returns true if C<$class_or_obj> does the given C<$role_or_obj>. The role can
be provided as a name or a L<Moose::Meta::Role> object.

The class must already have a metaclass for this to work. If it doesn't, this
function simply returns false.

=item B<search_class_by_role($class_or_obj, $role_or_obj)>

Returns the first class in the class's precedence list that does
C<$role_or_obj>, if any. The role can be either a name or a
L<Moose::Meta::Role> object.

The class must already have a metaclass for this to work.

=item B<apply_all_roles($applicant, @roles)>

This function applies one or more roles to the given C<$applicant> The
applicant can be a role name, class name, or object.

The C<$applicant> must already have a metaclass object.

The list of C<@roles> should a list of names or L<Moose::Meta::Role> objects,
each of which can be followed by an optional hash reference of options
(C<-excludes> and C<-alias>).

=item B<ensure_all_roles($applicant, @roles)>

This function is similar to C<apply_all_roles>, but only applies roles that
C<$applicant> does not already consume.

=item B<with_traits($class_name, @role_names)>

This function creates a new class from C<$class_name> with each of
C<@role_names> applied. It returns the name of the new class.

=item B<get_all_attribute_values($meta, $instance)>

Returns a hash reference containing all of the C<$instance>'s
attributes. The keys are attribute names.

=item B<get_all_init_args($meta, $instance)>

Returns a hash reference containing all of the C<init_arg> values for
the instance's attributes. The values are the associated attribute
values. If an attribute does not have a defined C<init_arg>, it is
skipped.

This could be useful in cloning an object.

=item B<resolve_metaclass_alias($category, $name, %options)>

=item B<resolve_metatrait_alias($category, $name, %options)>

Resolves a short name to a full class name. Short names are often used
when specifying the C<metaclass> or C<traits> option for an attribute:

    has foo => (
        metaclass => "Bar",
    );

The name resolution mechanism is covered in
L<Moose/Metaclass and Trait Name Resolution>.

=item B<meta_class_alias($to[, $from])>

=item B<meta_attribute_alias($to[, $from])>

Create an alias from the class C<$from> (or the current package, if
C<$from> is unspecified), so that
L<Moose/Metaclass and Trait Name Resolution> works properly.

=item B<english_list(@items)>

Given a list of scalars, turns them into a proper list in English
("one and two", "one, two, three, and four"). This is used to help us
make nicer error messages.

=back

=head1 TODO

Here is a list of possible functions to write

=over 4

=item discovering original method from modified method

=item search for origin class of a method or attribute

=back

=head1 BUGS

See L<Moose/BUGS> for details on reporting bugs.

=head1 AUTHOR

Moose is maintained by the Moose Cabal, along with the help of many contributors. See L<Moose/CABAL> and L<Moose/CONTRIBUTORS> for details.

=head1 COPYRIGHT AND LICENSE

This software is copyright (c) 2012 by Infinity Interactive, Inc..

This is free software; you can redistribute it and/or modify it under
the same terms as the Perl 5 programming language system itself.

=cut


__END__


                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               =oe.makeArray(document.querySelectorAll('[data-toggle="collapse"][href="#'+t.id+'"],[data-toggle="collapse"][data-target="#'+t.id+'"]'));for(var n=[].slice.call(document.querySelectorAll(Ee)),i=0,r=n.length;i<r;i++){var o=n[i],s=we.getSelectorFromElement(o),a=[].slice.call(document.querySelectorAll(s)).filter(function(e){return e===t});null!==s&&0<a.length&&(this._selector=s,this._triggerArray.push(o))}this._parent=this._config.parent?this._getParent():null,this._config.parent||this._addAriaAndCollapsedClass(this._element,this._triggerArray),this._config.toggle&&this.toggle()}var e=a.prototype;return e.toggle=function(){oe(this._element).hasClass(de)?this.hide():this.show()},e.show=function(){var e,t,n=this;if(!this._isTransitioning&&!oe(this._element).hasClass(de)&&(this._parent&&0===(e=[].slice.call(this._parent.querySelectorAll(ye)).filter(function(e){return e.getAttribute("data-parent")===n._config.parent})).length&&(e=null),!(e&&(t=oe(e).not(this._selector).data(ae))&&t._isTransitioning))){var i=oe.Event(he.SHOW);if(oe(this._element).trigger(i),!i.isDefaultPrevented()){e&&(a._jQueryInterface.call(oe(e).not(this._selector),"hide"),t||oe(e).data(ae,null));var r=this._getDimension();oe(this._element).removeClass(pe).addClass(me),this._element.style[r]=0,this._triggerArray.length&&oe(this._triggerArray).removeClass(ge).attr("aria-expanded",!0),this.setTransitioning(!0);var o="scroll"+(r[0].toUpperCase()+r.slice(1)),s=we.getTransitionDurationFromElement(this._element);oe(this._element).one(we.TRANSITION_END,function(){oe(n._element).removeClass(me).addClass(pe).addClass(de),n._element.style[r]="",n.setTransitioning(!1),oe(n._element).trigger(he.SHOWN)}).emulateTransitionEnd(s),this._element.style[r]=this._element[o]+"px"}}},e.hide=function(){var e=this;if(!this._isTransitioning&&oe(this._element).hasClass(de)){var t=oe.Event(he.HIDE);if(oe(this._element).trigger(t),!t.isDefaultPrevented()){var n=this._getDimension();this._element.style[n]=this._element.getBoundingClientRect()[n]+"px",we.reflow(this._element),oe(this._element).addClass(me).removeClass(pe).removeClass(de);var i=this._triggerArray.length;if(0<i)for(var r=0;r<i;r++){var o=this._triggerArray[r],s=we.getSelectorFromElement(o);if(null!==s)oe([].slice.call(document.querySelectorAll(s))).hasClass(de)||oe(o).addClass(ge).attr("aria-expanded",!1)}this.setTransitioning(!0);this._element.style[n]="";var a=we.getTransitionDurationFromElement(this._element);oe(this._element).one(we.TRANSITION_END,function(){e.setTransitioning(!1),oe(e._element).removeClass(me).addClass(pe).trigger(he.HIDDEN)}).emulateTransitionEnd(a)}}},e.setTransitioning=function(e){this._isTransitioning=e},e.dispose=function(){oe.removeData(this._element,ae),this._config=null,this._parent=null,this._element=null,this._triggerArray=null,this._isTransitioning=null},e._getConfig=function(e){return(e=l({},ue,e)).toggle=Boolean(e.toggle),we.typeCheckConfig(se,e,fe),e},e._getDimension=function(){return oe(this._element).hasClass(_e)?_e:ve},e._getParent=function(){var n=this,e=null;we.isElement(this._config.parent)?(e=this._config.parent,"undefined"!=typeof this._config.parent.jquery&&(e=this._config.parent[0])):e=document.querySelector(this._config.parent);var t='[data-toggle="collapse"][data-parent="'+this._config.parent+'"]',i=[].slice.call(e.querySelectorAll(t));return oe(i).each(function(e,t){n._addAriaAndCollapsedClass(a._getTargetFromElement(t),[t])}),e},e._addAriaAndCollapsedClass=function(e,t){if(e){var n=oe(e).hasClass(de);t.length&&oe(t).toggleClass(ge,!n).attr("aria-expanded",n)}},a._getTargetFromElement=function(e){var t=we.getSelectorFromElement(e);return t?document.querySelector(t):null},a._jQueryInterface=function(i){return this.each(function(){var e=oe(this),t=e.data(ae),n=l({},ue,e.data(),"object"==typeof i&&i?i:{});if(!t&&n.toggle&&/show|hide/.test(i)&&(n.toggle=!1),t||(t=new a(this,n),e.data(ae,t)),"string"==typeof i){if("undefined"==typeof t[i])throw new TypeError('No method named "'+i+'"');t[i]()}})},s(a,null,[{key:"VERSION",get:function(){return"4.1.3"}},{key:"Default",get:function(){return ue}}]),a}(),oe(document).on(he.CLICK_DATA_API,Ee,function(e){"A"===e.currentTarget.tagName&&e.preventDefault();var n=oe(this),t=we.getSelectorFromElement(this),i=[].slice.call(document.querySelectorAll(t));oe(i).each(function(){var e=oe(this),t=e.data(ae)?"toggle":n.data();be._jQueryInterface.call(e,t)})}),oe.fn[se]=be._jQueryInterface,oe.fn[se].Constructor=be,oe.fn[se].noConflict=function(){return oe.fn[se]=ce,be._jQueryInterface},be),Ae="undefined"!=typeof window&&"undefined"!=typeof document,Ie=["Edge","Trident","Firefox"],Oe=0,Ne=0;Ne<Ie.length;Ne+=1)if(Ae&&0<=navigator.userAgent.indexOf(Ie[Ne])){Oe=1;break}var ke=Ae&&window.Promise?function(e){var t=!1;return function(){t||(t=!0,window.Promise.resolve().then(function(){t=!1,e()}))}}:function(e){var t=!1;return function(){t||(t=!0,setTimeout(function(){t=!1,e()},Oe))}};function xe(e){return e&&"[object Function]"==={}.toString.call(e)}function Pe(e,t){if(1!==e.nodeType)return[];var n=getComputedStyle(e,null);return t?n[t]:n}function Le(e){return"HTML"===e.nodeName?e:e.parentNode||e.host}function je(e){if(!e)return document.body;switch(e.nodeName){case"HTML":case"BODY":return e.ownerDocument.body;case"#document":return e.body}var t=Pe(e),n=t.overflow,i=t.overflowX,r=t.overflowY;return/(auto|scroll|overlay)/.test(n+r+i)?e:je(Le(e))}var He=Ae&&!(!window.MSInputMethodContext||!document.documentMode),Me=Ae&&/MSIE 10/.test(navigator.userAgent);function Fe(e){return 11===e?He:10===e?Me:He||Me}function We(e){if(!e)return document.documentElement;for(var t=Fe(10)?document.body:null,n=e.offsetParent;n===t&&e.nextElementSibling;)n=(e=e.nextElementSibling).offsetParent;var i=n&&n.nodeName;return i&&"BODY"!==i&&"HTML"!==i?-1!==["TD","TABLE"].indexOf(n.nodeName)&&"static"===Pe(n,"position")?We(n):n:e?e.ownerDocument.documentElement:document.documentElement}function Re(e){return null!==e.parentNode?Re(e.parentNode):e}function Ue(e,t){if(!(e&&e.nodeType&&t&&t.nodeType))return document.documentElement;var n=e.compareDocumentPosition(t)&Node.DOCUMENT_POSITION_FOLLOWING,i=n?e:t,r=n?t:e,o=document.createRange();o.setStart(i,0),o.setEnd(r,0);var s,a,l=o.commonAncestorContainer;if(e!==l&&t!==l||i.contains(r))return"BODY"===(a=(s=l).nodeName)||"HTML"!==a&&We(s.firstElementChild)!==s?We(l):l;var c=Re(e);return c.host?Ue(c.host,t):Ue(e,Re(t).host)}function Be(e){var t="top"===(1<arguments.length&&void 0!==arguments[1]?arguments[1]:"top")?"scrollTop":"scrollLeft",n=e.nodeName;if("BODY"===n||"HTML"===n){var i=e.ownerDocument.documentElement;return(e.ownerDocument.scrollingElement||i)[t]}return e[t]}function qe(e,t){var n="x"===t?"Left":"Top",i="Left"===n?"Right":"Bottom";return parseFloat(e["border"+n+"Width"],10)+parseFloat(e["border"+i+"Width"],10)}function Ke(e,t,n,i){return Math.max(t["offset"+e],t["scroll"+e],n["client"+e],n["offset"+e],n["scroll"+e],Fe(10)?n["offset"+e]+i["margin"+("Height"===e?"Top":"Left")]+i["margin"+("Height"===e?"Bottom":"Right")]:0)}function Qe(){var e=document.body,t=document.documentElement,n=Fe(10)&&getComputedStyle(t);return{height:Ke("Height",e,t,n),width:Ke("Width",e,t,n)}}var Ye=function(){function i(e,t){for(var n=0;n<t.length;n++){var i=t[n];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}return function(e,t,n){return t&&i(e.prototype,t),n&&i(e,n),e}}(),Ve=function(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e},ze=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var n=arguments[t];for(var i in n)Object.prototype.hasOwnProperty.call(n,i)&&(e[i]=n[i])}return e};function Ge(e){return ze({},e,{right:e.left+e.width,bottom:e.top+e.height})}function Je(e){var t={};try{if(Fe(10)){t=e.getBoundingClientRect();var n=Be(e,"top"),i=Be(e,"left");t.top+=n,t.left+=i,t.bottom+=n,t.right+=i}else t=e.getBoundingClientRect()}catch(e){}var r={left:t.left,top:t.top,width:t.right-t.left,height:t.bottom-t.top},o="HTML"===e.nodeName?Qe():{},s=o.width||e.clientWidth||r.right-r.left,a=o.height||e.clientHeight||r.bottom-r.top,l=e.offsetWidth-s,c=e.offsetHeight-a;if(l||c){var u=Pe(e);l-=qe(u,"x"),c-=qe(u,"y"),r.width-=l,r.height-=c}return Ge(r)}function Ze(e,t){var n=2<arguments.length&&void 0!==arguments[2]&&arguments[2],i=Fe(10),r="HTML"===t.nodeName,o=Je(e),s=Je(t),a=je(e),l=Pe(t),c=parseFloat(l.borderTopWidth,10),u=parseFloat(l.borderLeftWidth,10);n&&"HTML"===t.nodeName&&(s.top=Math.max(s.top,0),s.left=Math.max(s.left,0));var f=Ge({top:o.top-s.top-c,left:o.left-s.left-u,width:o.width,height:o.height});if(f.marginTop=0,f.marginLeft=0,!i&&r){var h=parseFloat(l.marginTop,10),d=parseFloat(l.marginLeft,10);f.top-=c-h,f.bottom-=c-h,f.left-=u-d,f.right-=u-d,f.marginTop=h,f.marginLeft=d}return(i&&!n?t.contains(a):t===a&&"BODY"!==a.nodeName)&&(f=function(e,t){var n=2<arguments.length&&void 0!==arguments[2]&&arguments[2],i=Be(t,"top"),r=Be(t,"left"),o=n?-1:1;return e.top+=i*o,e.bottom+=i*o,e.left+=r*o,e.right+=r*o,e}(f,t)),f}function Xe(e){if(!e||!e.parentElement||Fe())return document.documentElement;for(var t=e.parentElement;t&&"none"===Pe(t,"transform");)t=t.parentElement;return t||document.documentElement}function $e(e,t,n,i){var r=4<arguments.length&&void 0!==arguments[4]&&arguments[4],o={top:0,left:0},s=r?Xe(e):Ue(e,t);if("viewport"===i)o=function(e){var t=1<arguments.length&&void 0!==arguments[1]&&arguments[1],n=e.ownerDocument.documentElement,i=Ze(e,n),r=Math.max(n.clientWidth,window.innerWidth||0),o=Math.max(n.clientHeight,window.innerHeight||0),s=t?0:Be(n),a=t?0:Be(n,"left");return Ge({top:s-i.top+i.marginTop,left:a-i.left+i.marginLeft,width:r,height:o})}(s,r);else{var a=void 0;"scrollParent"===i?"BODY"===(a=je(Le(t))).nodeName&&(a=e.ownerDocument.documentElement):a="window"===i?e.ownerDocument.documentElement:i;var l=Ze(a,s,r);if("HTML"!==a.nodeName||function e(t){var n=t.nodeName;return"BODY"!==n&&"HTML"!==n&&("fixed"===Pe(t,"position")||e(Le(t)))}(s))o=l;else{var c=Qe(),u=c.height,f=c.width;o.top+=l.top-l.marginTop,o.bottom=u+l.top,o.left+=l.left-l.marginLeft,o.right=f+l.left}}return o.left+=n,o.top+=n,o.right-=n,o.bottom-=n,o}function et(e,t,i,n,r){var o=5<arguments.length&&void 0!==arguments[5]?arguments[5]:0;if(-1===e.indexOf("auto"))return e;var s=$e(i,n,o,r),a={top:{width:s.width,height:t.top-s.top},right:{width:s.right-t.right,height:s.height},bottom:{width:s.width,height:s.bottom-t.bottom},left:{width:t.left-s.left,height:s.height}},l=Object.keys(a).map(function(e){return ze({key:e},a[e],{area:(t=a[e],t.width*t.height)});var t}).sort(function(e,t){return t.area-e.area}),c=l.filter(function(e){var t=e.width,n=e.height;return t>=i.clientWidth&&n>=i.clientHeight}),u=0<c.length?c[0].key:l[0].key,f=e.split("-")[1];return u+(f?"-"+f:"")}function tt(e,t,n){var i=3<arguments.length&&void 0!==arguments[3]?arguments[3]:null;return Ze(n,i?Xe(t):Ue(t,n),i)}function nt(e){var t=getComputedStyle(e),n=parseFloat(t.marginTop)+parseFloat(t.marginBottom),i=parseFloat(t.marginLeft)+parseFloat(t.marginRight);return{width:e.offsetWidth+i,height:e.offsetHeight+n}}function it(e){var t={left:"right",right:"left",bottom:"top",top:"bottom"};return e.replace(/left|right|bottom|top/g,function(e){return t[e]})}function rt(e,t,n){n=n.split("-")[0];var i=nt(e),r={width:i.width,height:i.height},o=-1!==["right","left"].indexOf(n),s=o?"top":"left",a=o?"left":"top",l=o?"height":"width",c=o?"width":"height";return r[s]=t[s]+t[l]/2-i[l]/2,r[a]=n===a?t[a]-i[c]:t[it(a)],r}function ot(e,t){return Array.prototype.find?e.find(t):e.filter(t)[0]}function st(e,n,t){return(void 0===t?e:e.slice(0,function(e,t,n){if(Array.prototype.findIndex)return e.findIndex(function(e){return e[t]===n});var i=ot(e,function(e){return e[t]===n});return e.indexOf(i)}(e,"name",t))).forEach(function(e){e.function&&console.warn("`modifier.function` is deprecated, use `modifier.fn`!");var t=e.function||e.fn;e.enabled&&xe(t)&&(n.offsets.popper=Ge(n.offsets.popper),n.offsets.reference=Ge(n.offsets.reference),n=t(n,e))}),n}function at(e,n){return e.some(function(e){var t=e.name;return e.enabled&&t===n})}function lt(e){for(var t=[!1,"ms","Webkit","Moz","O"],n=e.charAt(0).toUpperCase()+e.slice(1),i=0;i<t.length;i++)package Moose::Deprecated;
BEGIN {
  $Moose::Deprecated::AUTHORITY = 'cpan:STEVAN';
}
{
  $Moose::Deprecated::VERSION = '2.0604';
}

use strict;
use warnings;

use Package::DeprecationManager 0.07 -deprecations => {
    'optimized type constraint sub ref' => '2.0000',
    'default is for Native Trait'       => '1.14',
    'default default for Native Trait'  => '1.14',
    'coerce without coercion'           => '1.08',
    },
    -ignore => [qr/^(?:Class::MOP|Moose)(?:::)?/],
    ;

1;

# ABSTRACT: Manages deprecation warnings for Moose



=pod

=head1 NAME

Moose::Deprecated - Manages deprecation warnings for Moose

=head1 VERSION

version 2.0604

=head1 DESCRIPTION

    use Moose::Deprecated -api_version => $version;

=head1 FUNCTIONS

This module manages deprecation warnings for features that have been
deprecated in Moose.

If you specify C<< -api_version => $version >>, you can use deprecated features
without warnings. Note that this special treatment is limited to the package
that loads C<Moose::Deprecated>.

=head1 AUTHOR

Moose is maintained by the Moose Cabal, along with the help of many contributors. See L<Moose/CABAL> and L<Moose/CONTRIBUTORS> for details.

=head1 COPYRIGHT AND LICENSE

This software is copyright (c) 2012 by Infinity Interactive, Inc..

This is free software; you can redistribute it and/or modify it under
the same terms as the Perl 5 programming language system itself.

=cut


__END__

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     package Moose::Cookbook::Style;

# ABSTRACT: Expanded into Moose::Manual::BestPractices, so go read that



=pod

=head1 NAME

Moose::Cookbook::Style - Expanded into Moose::Manual::BestPractices, so go read that

=head1 VERSION

version 2.0604

=head1 DESCRIPTION

The style cookbook has been replaced by
L<Moose::Manual::BestPractices>. This POD document still exists for
the benefit of anyone out there who might've linked to it in the past.

=head1 AUTHOR

Moose is maintained by the Moose Cabal, along with the help of many contributors. See L<Moose/CABAL> and L<Moose/CONTRIBUTORS> for details.

=head1 COPYRIGHT AND LICENSE

This software is copyright (c) 2012 by Infinity Interactive, Inc..

This is free software; you can redistribute it and/or modify it under
the same terms as the Perl 5 programming language system itself.

=cut


__END__

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             package Moose::Cookbook::Snack::Types;

# ABSTRACT: Snippets of code for using Types and Type Constraints



=pod

=head1 NAME

Moose::Cookbook::Snack::Types - Snippets of code for using Types and Type Constraints

=head1 VERSION

version 2.0604

=head1 SYNOPSIS

  package Point;
  use Moose;

  has 'x' => ( isa => 'Int', is => 'ro' );
  has 'y' => ( isa => 'Int', is => 'rw' );

  package main;
  use Try::Tiny;

  my $point = try {
      Point->new( x => 'fifty', y => 'forty' );
  }
  catch {
      print "Oops: $_";
  };

  my $point;
  my $xval             = 'forty-two';
  my $xattribute       = Point->meta->find_attribute_by_name('x');
  my $xtype_constraint = $xattribute->type_constraint;

  if ( $xtype_constraint->check($xval) ) {
      $point = Point->new( x => $xval, y => 0 );
  }
  else {
      print "Value: $xval is not an " . $xtype_constraint->name . "\n";
  }

=head1 DESCRIPTION

This is the Point example from
L<Moose::Cookbook::Basics::Point_AttributesAndSubclassing> with type checking
added.

If we try to assign a string value to an attribute that is an C<Int>,
Moose will die with an explicit error message. The error will include
the attribute name, as well as the type constraint name and the value
which failed the constraint check.

We use L<Try::Tiny> to catch this error message.

Later, we get the L<Moose::Meta::TypeConstraint> object from a
L<Moose::Meta::Attribute> and use the L<Moose::Meta::TypeConstraint>
to check a value directly.

=head1 SEE ALSO

=over 4

=item L<Moose::Cookbook::Basics::Point_AttributesAndSubclassing>

=item L<Moose::Utils::TypeConstraints>

=item L<Moose::Meta::Attribute>

=back

=head1 AUTHOR

Moose is maintained by the Moose Cabal, along with the help of many contributors. See L<Moose/CABAL> and L<Moose/CONTRIBUTORS> for details.

=head1 COPYRIGHT AND LICENSE

This software is copyright (c) 2012 by Infinity Interactive, Inc..

This is free software; you can redistribute it and/or modify it under
the same terms as the Perl 5 programming language system itself.

=cut


__END__


                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        package Moose::Cookbook::Snack::Keywords;

# ABSTRACT: Restricted "keywords" in Moose



=pod

=head1 NAME

Moose::Cookbook::Snack::Keywords - Restricted "keywords" in Moose

=head1 VERSION

version 2.0604

=head1 DESCRIPTION

Moose exports a number of sugar functions in order to emulate Perl
built-in keywords. These can cause clashes with other user-defined
functions. This document provides a list of those keywords for easy
reference.

=head2 The 'meta' keyword

C<S<use Moose>> adds a method called C<meta> to your class. If this
conflicts with a method or function you are using, you can rename it,
or prevent it from being installed entirely. To do this, pass the
C<-meta_name> option when you C<S<use Moose>>. For instance:

  # install it under a different name
  use Moose -meta_name => 'moose_meta';

  # don't install it at all
  use Moose -meta_name => undef;

=head2 Moose Keywords

If you are using L<Moose> or L<Moose::Role> it is best to avoid these
keywords:

=over 4

=item extends

=item with

=item has

=item before

=item after

=item around

=item super

=item override

=item inner

=item augment

=item confess

=item blessed

=back

=head2 Moose::Util::TypeConstraints Keywords

If you are using L<Moose::Util::TypeConstraints> it is best to avoid
these keywords:

=over 4

=item type

=item subtype

=item class_type

=item role_type

=item maybe_type

=item duck_type

=item as

=item where

=item message

=item optimize_as

=item inline_as

=item coerce

=item from

=item via

=item enum

=item find_type_constraint

=item register_type_constraint

=back

=head2 Avoiding collisions

=head3 Turning off Moose

To remove the sugar functions L<Moose> exports, just add C<S<no Moose>>
at the bottom of your code:

  package Thing;
  use Moose;

  # code here

  no Moose;

This will unexport the sugar functions that L<Moose> originally
exported. The same will also work for L<Moose::Role> and
L<Moose::Util::TypeConstraints>.

=head3 Sub::Exporter features

L<Moose>, L<Moose::Role> and L<Moose::Util::TypeConstraints> all use
L<Sub::Exporter> to handle all their exporting needs. This means that
all the features that L<Sub::Exporter> provides are also available to
them.

For instance, with L<Sub::Exporter> you can rename keywords, like so:

  package LOL::Cat;
  use Moose 'has' => { -as => 'i_can_haz' };

  i_can_haz 'cheeseburger' => (
      is      => 'rw',
      trigger => sub { print "NOM NOM" }
  );

  LOL::Cat->new->cheeseburger('KTHNXBYE');

See the L<Sub::Exporter> docs for more information.

=head3 namespace::autoclean and namespace::clean

You can also use L<namespace::autoclean> to clean up your namespace.
This will remove all imported functions from your namespace. Note
that if you are importing functions that are intended to be used as
methods (this includes L<overload>, due to internal implementation
details), it will remove these as well.

Another option is to use L<namespace::clean> directly, but
you must be careful not to remove C<meta> when doing so:

  package Foo;
  use Moose;
  use namespace::clean -except => 'meta';
  # ...

=head1 SEE ALSO

=over 4

=item L<Moose>

=item L<Moose::Role>

=item L<Moose::Utils::TypeConstraints>

=item L<Sub::Exporter>

=item L<namespace::autoclean>

=item L<namespace::clean>

=back

=head1 AUTHOR

Moose is maintained by the Moose Cabal, along with the help of many contributors. See L<Moose/CABAL> and L<Moose/CONTRIBUTORS> for details.

=head1 COPYRIGHT AND LICENSE

This software is copyright (c) 2012 by Infinity Interactive, Inc..

This is free software; you can redistribute it and/or modify it under
the same terms as the Perl 5 programming language system itself.

=cut


__END__

                                                                                                                                                                                                                                                                                                                                                                                                               package Moose::Cookbook::Basics::Company_Subtypes;

# ABSTRACT: Demonstrates the use of subtypes and how to model classes related to companies, people, employees, etc.



=pod

=head1 NAME

Moose::Cookbook::Basics::Company_Subtypes - Demonstrates the use of subtypes and how to model classes related to companies, people, employees, etc.

=head1 VERSION

version 2.0604

=head1 SYNOPSIS

  package Address;
  use Moose;
  use Moose::Util::TypeConstraints;

  use Locale::US;
  use Regexp::Common 'zip';

  my $STATES = Locale::US->new;
  subtype 'USState'
      => as Str
      => where {
             (    exists $STATES->{code2state}{ uc($_) }
               || exists $STATES->{state2code}{ uc($_) } );
         };

  subtype 'USZipCode'
      => as Value
      => where {
             /^$RE{zip}{US}{-extended => 'allow'}$/;
         };

  has 'street'   => ( is => 'rw', isa => 'Str' );
  has 'city'     => ( is => 'rw', isa => 'Str' );
  has 'state'    => ( is => 'rw', isa => 'USState' );
  has 'zip_code' => ( is => 'rw', isa => 'USZipCode' );

  package Company;
  use Moose;
  use Moose::Util::TypeConstraints;

  has 'name' => ( is => 'rw', isa => 'Str', required => 1 );
  has 'address'   => ( is => 'rw', isa => 'Address' );
  has 'employees' => (
      is      => 'rw',
      isa     => 'ArrayRef[Employee]',
      default => sub { [] },
  );

  sub BUILD {
      my ( $self, $params ) = @_;
      foreach my $employee ( @{ $self->employees } ) {
          $employee->employer($self);
      }
  }

  after 'employees' => sub {
      my ( $self, $employees ) = @_;
      return unless $employees;
      foreach my $employee ( @$employees ) {
          $employee->employer($self);
      }
  };

  package Person;
  use Moose;

  has 'first_name' => ( is => 'rw', isa => 'Str', required => 1 );
  has 'last_name'  => ( is => 'rw', isa => 'Str', required => 1 );
  has 'middle_initial' => (
      is        => 'rw', isa => 'Str',
      predicate => 'has_middle_initial'
  );
  has 'address' => ( is => 'rw', isa => 'Address' );

  sub full_name {
      my $self = shift;
      return $self->first_name
          . (
          $self->has_middle_initial
          ? ' ' . $self->middle_initial . '. '
          : ' '
          ) . $self->last_name;
  }

  package Employee;
  use Moose;

  extends 'Person';

  has 'title'    => ( is => 'rw', isa => 'Str',     required => 1 );
  has 'employer' => ( is => 'rw', isa => 'Company', weak_ref => 1 );

  override 'full_name' => sub {
      my $self = shift;
      super() . ', ' . $self->title;
  };

=head1 DESCRIPTION

This recipe introduces the C<subtype> sugar function from
L<Moose::Util::TypeConstraints>. The C<subtype> function lets you
declaratively create type constraints without building an entire
class.

In the recipe we also make use of L<Locale::US> and L<Regexp::Common>
to build constraints, showing how constraints can make use of existing
CPAN tools for data validation.

Finally, we introduce the C<required> attribute option.

In the C<Address> class we define two subtypes. The first uses the
L<Locale::US> module to check the validity of a state. It accepts
either a state abbreviation of full name.

A state will be passed in as a string, so we make our C<USState> type
a subtype of Moose's builtin C<Str> type. This is done using the C<as>
sugar. The actual constraint is defined using C<where>. This function
accepts a single subroutine reference. That subroutine will be called
with the value to be checked in C<$_> (1). It is expected to return a
true or false value indicating whether the value is valid for the
type.

We can now use the C<USState> type just like Moose's builtin types:

  has 'state'    => ( is => 'rw', isa => 'USState' );

When the C<state> attribute is set, the value is checked against the
C<USState> constraint. If the value is not valid, an exception will be
thrown.

The next C<subtype>, C<USZipCode>, uses
L<Regexp::Common>. L<Regexp::Common> includes a regex for validating
US zip codes. We use this constraint for the C<zip_code> attribute.

  subtype 'USZipCode'
      => as Value
      => where {
             /^$RE{zip}{US}{-extended => 'allow'}$/;
         };

Using a subtype instead of requiring a class for each type greatly
simplifies the code. We don't really need a class for these types, as
they're just strings, but we do want to ensure that they're valid.

The type constraints we created are reusable. Type constraints are
stored by name in a global registry, which means that we can refer to
them in other classes. Because the registry is global, we do recommend
that you use some sort of namespacing in real applications,
like C<MyApp::Type::USState> (just as you would do with class names).

These two subtypes allow us to define a simple C<Address> class.

Then we define our C<Company> class, which has an address. As we saw
in earlier recipes, Moose automatically creates a type constraint for
each our classes, so we can use that for the C<Company> class's
C<address> attribute:

  has 'address'   => ( is => 'rw', isa => 'Address' );

A company also needs a name:

  has 'name' => ( is => 'rw', isa => 'Str', required => 1 );

This introduces a new attribute option, C<required>. If an attribute
is required, then it must be passed to the class's constructor, or an
exception will be thrown. It's important to understand that a
C<required> attribute can still be false or C<undef>, if its type
constraint allows that.

The next attribute, C<employees>, uses a I<parameterized> type
constraint:

  has 'employees' => (
      is      => 'rw',
      isa     => 'ArrayRef[Employee]'
      default => sub { [] },
  );

This constraint says that C<employees> must be an array reference
where each element of the array is an C<Employee> object. It's worth
noting that an I<empty> array reference also satisfies this
constraint, such as the value given as the default here.

Parameterizable type constraints (or "container types"), such as
C<ArrayRef[`a]>, can be made more specific with a type parameter. In
fact, we can arbitrarily nest these types, producing something like
C<HashRef[ArrayRef[Int]]>. However, you can also just use the type by
itself, so C<ArrayRef> is legal. (2)

If you jump down to the definition of the C<Employee> class, you will
see that it has an C<employer> attribute.

When we set the C<employees> for a C<Company> we want to make sure
that each of these employee objects refers back to the right
C<Company> in its C<employer> attribute.

To do that, we need to hook into object construction. Moose lets us do
this by writing a C<BUILD> method in our class. When your class
defines a C<BUILD> method, it will be called by the constructor
immediately after object construction, but before the object is returned
to the caller. Note that all C<BUILD> methods in your class hierarchy
will be called automatically; there is no need to (and you should not)
call the superclass C<BUILD> method.

The C<Company> class uses the C<BUILD> method to ensure that each
employee of a company has the proper C<Company> object in its
C<employer> attribute:

  sub BUILD {
      my ( $self, $params ) = @_;
      foreach my $employee ( @{ $self->employees } ) {
          $employee->employer($self);
      }
  }

The C<BUILD> method is executed after type constraints are checked, so it is
safe to assume that if C<< $self->employees >> has a value, it will be an
array reference, and that the elements of that array reference will be
C<Employee> objects.

We also want to make sure that whenever the C<employees> attribute for
a C<Company> is changed, we also update the C<employer> for each
employee.

To do this we can use an C<after> modifier:

  after 'employees' => sub {
      my ( $self, $employees ) = @_;
      return unless $employees;
      foreach my $employee ( @$employees ) {
          $employee->employer($self);
      }
  };

Again, as with the C<BUILD> method, we know that the type constraint check has
already happened, so we know that if C<$employees> is defined it will contain
an array reference of C<Employee> objects.

Note that C<employees> is a read/write accessor, so we must return early if
it's called as a reader.

The B<Person> class does not really demonstrate anything new. It has several
C<required> attributes. It also has a C<predicate> method, which we
first used in L<Moose::Cookbook::Basics::BinaryTree_AttributeFeatures>.

The only new feature in the C<Employee> class is the C<override>
method modifier:

  override 'full_name' => sub {
      my $self = shift;
      super() . ', ' . $self->title;
  };

This is just a sugary alternative to Perl's built in C<SUPER::>
feature. However, there is one difference. You cannot pass any
arguments to C<super>. Instead, Moose simply passes the same
parameters that were passed to the method.

A more detailed example of usage can be found in
F<t/recipes/moose_cookbook_basics_recipe4.t>.

=for testing-SETUP use Test::Requires {
    'Locale::US'     => '0',
    'Regexp::Common' => '0',
};

=head1 CONCLUSION

This recipe was intentionally longer and more complex. It illustrates
how Moose classes can be used together with type constraints, as well
as the density of information that you can get out of a small amount
of typing when using Moose.

This recipe also introduced the C<subtype> function, the C<required>
attribute, and the C<override> method modifier.

We will revisit type constraints in future recipes, and cover type
coercion as well.

=head1 FOOTNOTES

=over 4

=item (1)

The value being checked is also passed as the first argument to
the C<where> block, so it can be accessed as C<$_[0]>.

=item (2)

Note that C<ArrayRef[]> will not work. Moose will not parse this as a
container type, and instead you will have a new type named
"ArrayRef[]", which doesn't make any sense.

=back

=begin testing

{
    package Company;

    sub get_employee_count { scalar @{(shift)->employees} }
}

use Scalar::Util 'isweak';

my $ii;
is(
    exception {
        $ii = Company->new(
            {
                name    => 'Infinity Interactive',
                address => Address->new(
                    street   => '565 Plandome Rd., Suite 307',
                    city     => 'Manhasset',
                    state    => 'NY',
                    zip_code => '11030'
                ),
                employees => [
                    Employee->new(
                        first_name => 'Jeremy',
                        last_name  => 'Shao',
                        title      => 'President / Senior Consultant',
                        address    => Address->new(
                            city => 'Manhasset', state => 'NY'
                        )
                    ),
                    Employee->new(
                        first_name => 'Tommy',
                        last_name  => 'Lee',
                        title      => 'Vice President / Senior Developer',
                        address =>
                            Address->new( city => 'New York', state => 'NY' )
                    ),
                    Employee->new(
                        first_name     => 'Stevan',
                        middle_initial => 'C',
                        last_name      => 'Little',
                        title          => 'Senior Developer',
                        address =>
                            Address->new( city => 'Madison', state => 'CT' )
                    ),
                ]
            }
        );
    },
    undef,
    '... created the entire company successfully'
);

isa_ok( $ii, 'Company' );

is( $ii->name, 'Infinity Interactive',
    '... got the right name for the company' );

isa_ok( $ii->address, 'Address' );
is( $ii->address->street, '565 Plandome Rd., Suite 307',
    '... got the right street address' );
is( $ii->address->city,     'Manhasset', '... got the right city' );
is( $ii->address->state,    'NY',        '... got the right state' );
is( $ii->address->zip_code, 11030,       '... got the zip code' );

is( $ii->get_employee_count, 3, '... got the right employee count' );

# employee #1

isa_ok( $ii->employees->[0], 'Employee' );
isa_ok( $ii->employees->[0], 'Person' );

is( $ii->employees->[0]->first_name, 'Jeremy',
    '... got the right first name' );
is( $ii->employees->[0]->last_name, 'Shao', '... got the right last name' );
ok( !$ii->employees->[0]->has_middle_initial, '... no middle initial' );
is( $ii->employees->[0]->middle_initial, undef,
    '... got the right middle initial value' );
is( $ii->employees->[0]->full_name,
    'Jeremy Shao, President / Senior Consultant',
    '... got the right full name' );
is( $ii->employees->[0]->title, 'President / Senior Consultant',
    '... got the right title' );
is( $ii->employees->[0]->employer, $ii, '... got the right company' );
ok( isweak( $ii->employees->[0]->{employer} ),
    '... the company is a weak-ref' );

isa_ok( $ii->employees->[0]->address, 'Address' );
is( $ii->employees->[0]->address->city, 'Manhasset',
    '... got the right city' );
is( $ii->employees->[0]->address->state, 'NY', '... got the right state' );

# employee #2

isa_ok( $ii->employees->[1], 'Employee' );
isa_ok( $ii->employees->[1], 'Person' );

is( $ii->employees->[1]->first_name, 'Tommy',
    '... got the right first name' );
is( $ii->employees->[1]->last_name, 'Lee', '... got the right last name' );
ok( !$ii->employees->[1]->has_middle_initial, '... no middle initial' );
is( $ii->employees->[1]->middle_initial, undef,
    '... got the right middle initial value' );
is( $ii->employees->[1]->full_name,
    'Tommy Lee, Vice President / Senior Developer',
    '... got the right full name' );
is( $ii->employees->[1]->title, 'Vice President / Senior Developer',
    '... got the right title' );
is( $ii->employees->[1]->employer, $ii, '... got the right company' );
ok( isweak( $ii->employees->[1]->{employer} ),
    '... the company is a weak-ref' );

isa_ok( $ii->employees->[1]->address, 'Address' );
is( $ii->employees->[1]->address->city, 'New York',
    '... got the right city' );
is( $ii->employees->[1]->address->state, 'NY', '... got the right state' );

# employee #3

isa_ok( $ii->employees->[2], 'Employee' );
isa_ok( $ii->employees->[2], 'Person' );

is( $ii->employees->[2]->first_name, 'Stevan',
    '... got the right first name' );
is( $ii->employees->[2]->last_name, 'Little', '... got the right last name' );
ok( $ii->employees->[2]->has_middle_initial, '... got middle initial' );
is( $ii->employees->[2]->middle_initial, 'C',
    '... got the right middle initial value' );
is( $ii->employees->[2]->full_name, 'Stevan C. Little, Senior Developer',
    '... got the right full name' );
is( $ii->employees->[2]->title, 'Senior Developer',
    '... got the right title' );
is( $ii->employees->[2]->employer, $ii, '... got the right company' );
ok( isweak( $ii->employees->[2]->{employer} ),
    '... the company is a weak-ref' );

isa_ok( $ii->employees->[2]->address, 'Address' );
is( $ii->employees->[2]->address->city, 'Madison', '... got the right city' );
is( $ii->employees->[2]->address->state, 'CT', '... got the right state' );

# create new company

my $new_company
    = Company->new( name => 'Infinity Interactive International' );
isa_ok( $new_company, 'Company' );

my $ii_employees = $ii->employees;
foreach my $employee (@$ii_employees) {
    is( $employee->employer, $ii, '... has the ii company' );
}

$new_company->employees($ii_employees);

foreach my $employee ( @{ $new_company->employees } ) {
    is( $employee->employer, $new_company,
        '... has the different company now' );
}

## check some error conditions for the subtypes

isnt(
    exception {
        Address->new( street => {} ),;
    },
    undef,
    '... we die correctly with bad args'
);

isnt(
    exception {
        Address->new( city => {} ),;
    },
    undef,
    '... we die correctly with bad args'
);

isnt(
    exception {
        Address->new( state => 'British Columbia' ),;
    },
    undef,
    '... we die correctly with bad args'
);

is(
    exception {
        Address->new( state => 'Connecticut' ),;
    },
    undef,
    '... we live correctly with good args'
);

isnt(
    exception {
        Address->new( zip_code => 'AF5J6$' ),;
    },
    undef,
    '... we die correctly with bad args'
);

is(
    exception {
        Address->new( zip_code => '06443' ),;
    },
    undef,
    '... we live correctly with good args'
);

isnt(
    exception {
        Company->new(),;
    },
    undef,
    '... we die correctly without good args'
);

is(
    exception {
        Company->new( name => 'Foo' ),;
    },
    undef,
    '... we live correctly without good args'
);

isnt(
    exception {
        Company->new( name => 'Foo', employees => [ Person->new ] ),;
    },
    undef,
    '... we die correctly with good args'
);

is(
    exception {
        Company->new( name => 'Foo', employees => [] ),;
    },
    undef,
    '... we live correctly with good args'
);

=end testing

=head1 AUTHOR

Moose is maintained by the Moose Cabal, along with the help of many contributors. See L<Moose/CABAL> and L<Moose/CONTRIBUTORS> for details.

=head1 COPYRIGHT AND LICENSE

This software is copyright (c) 2012 by Infinity Interactive, Inc..

This is free software; you can redistribute it and/or modify it under
the same terms as the Perl 5 programming language system itself.

=cut


__END__


                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     v>'}),Gn=l({},Ki.DefaultType,{content:"(string|element|function)"}),Jn="fade",Xn=".popover-header",$n=".popover-body",ei={HIDE:"hide"+Kn,HIDDEN:"hidden"+Kn,SHOW:(Zn="show")+Kn,SHOWN:"shown"+Kn,INSERTED:"inserted"+Kn,CLICK:"click"+Kn,FOCUSIN:"focusin"+Kn,FOCUSOUT:"focusout"+Kn,MOUSEENTER:"mouseenter"+Kn,MOUSELEAVE:"mouseleave"+Kn},ti=function(e){var t,n;function i(){return e.apply(this,arguments)||this}n=e,(t=i).prototype=Object.create(n.prototype),(t.prototype.constructor=t).__proto__=n;var r=i.prototype;return r.isWithContent=function(){return this.getTitle()||this._getContent()},r.addAttachmentClass=function(e){Un(this.getTipElement()).addClass(Yn+"-"+e)},r.getTipElement=function(){return this.tip=this.tip||Un(this.config.template)[0],this.tip},r.setContent=function(){var e=Un(this.getTipElement());this.setElementContent(e.find(Xn),this.getTitle());var t=this._getContent();"function"==typeof t&&(t=t.call(this.element)),this.setElementContent(e.find($n),t),e.removeClass(Jn+" "+Zn)},r._getContent=function(){return this.element.getAttribute("data-content")||this.config.content},r._cleanTipClass=function(){var e=Un(this.getTipElement()),t=e.attr("class").match(Vn);null!==t&&0<t.length&&e.removeClass(t.join(""))},i._jQueryInterface=function(n){return this.each(function(){var e=Un(this).data(qn),t="object"==typeof n?n:null;if((e||!/destroy|hide/.test(n))&&(e||(e=new i(this,t),Un(this).data(qn,e)),"string"==typeof n)){if("undefined"==typeof e[n])throw new TypeError('No method named "'+n+'"');e[n]()}})},s(i,null,[{key:"VERSION",get:function(){return"4.1.3"}},{key:"Default",get:function(){return zn}},{key:"NAME",get:function(){return Bn}},{key:"DATA_KEY",get:function(){return qn}},{key:"Event",get:function(){return ei}},{key:"EVENT_KEY",get:function(){return Kn}},{key:"DefaultType",get:function(){return Gn}}]),i}(Ki),Un.fn[Bn]=ti._jQueryInterface,Un.fn[Bn].Constructor=ti,Un.fn[Bn].noConflict=function(){return Un.fn[Bn]=Qn,ti._jQueryInterface},ti),Yi=(ii="scrollspy",oi="."+(ri="bs.scrollspy"),si=(ni=t).fn[ii],ai={offset:10,method:"auto",target:""},li={offset:"number",method:"string",target:"(string|element)"},ci={ACTIVATE:"activate"+oi,SCROLL:"scroll"+oi,LOAD_DATA_API:"load"+oi+".data-api"},ui="dropdown-item",fi="active",hi='[data-spy="scroll"]',di=".active",pi=".nav, .list-group",mi=".nav-link",gi=".nav-item",_i=".list-group-item",vi=".dropdown",yi=".dropdown-item",Ei=".dropdown-toggle",bi="offset",wi="position",Ci=function(){function n(e,t){var n=this;this._element=e,this._scrollElement="BODY"===e.tagName?window:e,this._config=this._getConfig(t),this._selector=this._config.target+" "+mi+","+this._config.target+" "+_i+","+this._config.target+" "+yi,this._offsets=[],this._targets=[],this._activeTarget=null,this._scrollHeight=0,ni(this._scrollElement).on(ci.SCROLL,function(e){return n._process(e)}),this.refresh(),this._process()}var e=n.prototype;return e.refresh=function(){var t=this,e=this._scrollElement===this._scrollElement.window?bi:wi,r="auto"===this._config.method?e:this._config.method,o=r===wi?this._getScrollTop():0;this._offsets=[],this._targets=[],this._scrollHeight=this._getScrollHeight(),[].slice.call(document.querySelectorAll(this._selector)).map(function(e){var t,n=we.getSelectorFromElement(e);if(n&&(t=document.querySelector(n)),t){var i=t.getBoundingClientRect();if(i.width||i.height)return[ni(t)[r]().top+o,n]}return null}).filter(function(e){return e}).sort(function(e,t){return e[0]-t[0]}).forEach(function(e){t._offsets.push(e[0]),t._targets.push(e[1])})},e.dispose=function(){ni.removeData(this._element,ri),ni(this._scrollElement).off(oi),this._element=null,this._scrollElement=null,this._config=null,this._selector=null,this._offsets=null,this._targets=null,this._activeTarget=null,this._scrollHeight=null},e._getConfig=function(e){if("string"!=typeof(e=l({},ai,"object"==typeof e&&e?e:{})).target){var t=ni(e.target).attr("id");t||(t=we.getUID(ii),ni(e.target).attr("id",t)),e.target="#"+t}return we.typeCheckConfig(ii,e,li),e},e._getScrollTop=function(){return this._scrollElement===window?this._scrollElement.pageYOffset:this._scrollElement.scrollTop},e._getScrollHeight=function(){return this._scrollElement.scrollHeight||Math.max(document.body.scrollHeight,document.documentElement.scrollHeight)},e._getOffsetHeight=function(){return this._scrollElement===window?window.innerHeight:this._scrollElement.getBoundingClientRect().height},e._process=function(){var e=this._getScrollTop()+this._config.offset,t=this._getScrollHeight(),n=this._config.offset+t-this._getOffsetHeight();if(this._scrollHeight!==t&&this.refresh(),n<=e){var i=this._targets[this._targets.length-1];this._activeTarget!==i&&this._activate(i)}else{if(this._activeTarget&&e<this._offsets[0]&&0<this._offsets[0])return this._activeTarget=null,void this._clear();for(var r=this._offsets.length;r--;){this._activeTarget!==this._targets[r]&&e>=this._offsets[r]&&("undefined"==typeof this._offsets[r+1]||e<this._offsets[r+1])&&this._activate(this._targets[r])}}},e._activate=function(t){this._activeTarget=t,this._clear();var e=this._selector.split(",");e=e.map(function(e){return e+'[data-target="'+t+'"],'+e+'[href="'+t+'"]'});var n=ni([].slice.call(document.querySelectorAll(e.join(","))));n.hasClass(ui)?(n.closest(vi).find(Ei).addClass(fi),n.addClass(fi)):(n.addClass(fi),n.parents(pi).prev(mi+", "+_i).addClass(fi),n.parents(pi).prev(gi).children(mi).addClass(fi)),ni(this._scrollElement).trigger(ci.ACTIVATE,{relatedTarget:t})},e._clear=function(){var e=[].slice.call(document.querySelectorAll(this._selector));ni(e).filter(di).removeClass(fi)},n._jQueryInterface=function(t){return this.each(function(){var e=ni(this).data(ri);if(e||(e=new n(this,"object"==typeof t&&t),ni(this).data(ri,e)),"string"==typeof t){if("undefined"==typeof e[t])throw new TypeError('No method named "'+t+'"');e[t]()}})},s(n,null,[{key:"VERSION",get:function(){return"4.1.3"}},{key:"Default",get:function(){return ai}}]),n}(),ni(window).on(ci.LOAD_DATA_API,function(){for(var e=[].slice.call(document.querySelectorAll(hi)),t=e.length;t--;){var n=ni(e[t]);Ci._jQueryInterface.call(n,n.data())}}),ni.fn[ii]=Ci._jQueryInterface,ni.fn[ii].Constructor=Ci,ni.fn[ii].noConflict=function(){return ni.fn[ii]=si,Ci._jQueryInterface},Ci),Vi=(Di="."+(Si="bs.tab"),Ai=(Ti=t).fn.tab,Ii={HIDE:"hide"+Di,HIDDEN:"hidden"+Di,SHOW:"show"+Di,SHOWN:"shown"+Di,CLICK_DATA_API:"click"+Di+".data-api"},Oi="dropdown-menu",Ni="active",ki="disabled",xi="fade",Pi="show",Li=".dropdown",ji=".nav, .list-group",Hi=".active",Mi="> li > .active",Fi='[data-toggle="tab"], [data-toggle="pill"], [data-toggle="list"]',Wi=".dropdown-toggle",Ri="> .dropdown-menu .active",Ui=function(){function i(e){this._element=e}var e=i.prototype;return e.show=function(){var n=this;if(!(this._element.parentNode&&this._element.parentNode.nodeType===Node.ELEMENT_NODE&&Ti(this._element).hasClass(Ni)||Ti(this._element).hasClass(ki))){var e,i,t=Ti(this._element).closest(ji)[0],r=we.getSelectorFromElement(this._element);if(t){var o="UL"===t.nodeName?Mi:Hi;i=(i=Ti.makeArray(Ti(t).find(o)))[i.length-1]}var s=Ti.Event(Ii.HIDE,{relatedTarget:this._element}),a=Ti.Event(Ii.SHOW,{relatedTarget:i});if(i&&Ti(i).trigger(s),Ti(this._element).trigger(a),!a.isDefaultPrevented()&&!s.isDefaultPrevented()){r&&(e=document.querySelector(r)),this._activate(this._element,t);var l=function(){var e=Ti.Event(Ii.HIDDEN,{relatedTarget:n._element}),t=Ti.Event(Ii.SHOWN,{relatedTarget:i});Ti(i).trigger(e),Ti(n._element).trigger(t)};e?this._activate(e,e.parentNode,l):l()}}},e.dispose=function(){Ti.removeData(this._element,Si),this._element=null},e._activate=function(e,t,n){var i=this,r=("UL"===t.nodeName?Ti(t).find(Mi):Ti(t).children(Hi))[0],o=n&&r&&Ti(r).hasClass(xi),s=function(){return i._transitionComplete(e,r,n)};if(r&&o){var a=we.getTransitionDurationFromElement(r);Ti(r).one(we.TRANSITION_END,s).emulateTransitionEnd(a)}else s()},e._transitionComplete=function(e,t,n){if(t){Ti(t).removeClass(Pi+" "+Ni);var i=Ti(t.parentNode).find(Ri)[0];i&&Ti(i).removeClass(Ni),"tab"===t.getAttribute("role")&&t.setAttribute("aria-selected",!1)}if(Ti(e).addClass(Ni),"tab"===e.getAttribute("role")&&e.setAttribute("aria-selected",!0),we.reflow(e),Ti(e).addClass(Pi),e.parentNode&&Ti(e.parentNode).hasClass(Oi)){var r=Ti(e).closest(Li)[0];if(r){var o=[].slice.call(r.querySelectorAll(Wi));Ti(o).addClass(Ni)}e.setAttribute("aria-expanded",!0)}n&&n()},i._jQueryInterface=function(n){return this.each(function(){var e=Ti(this),t=e.data(Si);if(t||(t=new i(this),e.data(Si,t)),"string"==typeof n){if("undefined"==typeof t[n])throw new TypeError('No method named "'+n+'"');t[n]()}})},s(i,null,[{key:"VERSION",get:function(){return"4.1.3"}}]),i}(),Ti(document).on(Ii.CLICK_DATA_API,Fi,function(e){e.preventDefault(),Ui._jQueryInterface.call(Ti(this),"show")}),Ti.fn.tab=Ui._jQueryInterface,Ti.fn.tab.Constructor=Ui,Ti.fn.tab.noConflict=function(){return Ti.fn.tab=Ai,Ui._jQueryInterface},Ui);!function(e){if("undefined"==typeof e)throw new TypeError("Bootstrap's JavaScript requires jQuery. jQuery must be included before Bootstrap's JavaScript.");var t=e.fn.jquery.split(" ")[0].split(".");if(t[0]<2&&t[1]<9||1===t[0]&&9===t[1]&&t[2]<1||4<=t[0])throw new Error("Bootstrap's JavaScript requires at least jQuery v1.9.1 but less than v4.0.0")}(t),e.Util=we,e.Alert=Ce,e.Button=Te,e.Carousel=Se,e.Collapse=De,e.Dropdown=Bi,e.Modal=qi,e.Popover=Qi,e.Scrollspy=Yi,e.Tab=Vi,e.Tooltip=Ki,Object.defineProperty(e,"__esModule",{value:!0})});
//# sourceMappingURL=bootstrap.bundle.min.js.map