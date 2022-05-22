<?php
header("Content-Type:text/css");
$color = "#f0f";
function checkhexcolor($color)
{
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}

if (isset($_GET['color']) and $_GET['color'] != '') {
    $color = "#" . $_GET['color'];
}

if (!$color or !checkhexcolor($color)) {
    $color = "#336699";
}

function checkhexcolor2($secondColor)
{
    return preg_match('/^#[a-f0-9]{6}$/i', $secondColor);
}

?>

.pizza-item__content .right .price,.section-top-title,.call-btn i,.text--base,.testimonial-item i,.footer-inline-link li a:hover,.header .main-menu li a:hover, .header .main-menu li a:focus,.header .main-menu li a.active,.category-item__content .caption,.pizza-item .wishlist-btn i.fas,.pizza-order-wrapper__right .price,.custom--nav-tabs .nav-item .nav-link.active,.contact-info .icon,.read-more-btn:hover,.title a:hover,.s-post__title a:hover,.page-breadcrumb li:first-child::before,.h-delivery-btn p .mobile-num,.user-menu li.active a,.user-menu li a:hover,.custom-icon-field .form--control:focus ~ i,.progress-wrap::after,.preloader__inner .preloader-icon,.nav-right a:hover,.header .main-menu li.menu_has_children:hover > a::before, .track-item.active .title,.custom-icon-field .select:focus~i,.contact-info .content a:hover, .main-menu li a.active , .main-menu li a:hover, .main-menu li a:focus{
color:<?php echo $color ?> !important;
}

a:hover {
color:<?php echo $color ?>;
}


.section-top-title span::after,.section-top-title span::before,.testimonial-slider .slick-dots li.slick-active button,.btn--base,.bg--base,.custom--checkbox input:checked ~ label::before,.sidebar-widget__title::after,.custom--radio input[type=radio]:checked ~ label::before,.size-select .form-check .form-check-input:checked ~ .form-check-label,.post-share li a:hover,.blog-sidebar .title::after,.category-item__btn:hover, .sidebar-toggler-wrapper,.cart-btn-amount,.preloader__inner::before{
background-color:<?php echo $color ?> !important;
}
.border--base,.custom--checkbox input:checked ~ label::before,.custom--nav-tabs .nav-item .nav-link.active,.post-share li a:hover, .track-item.active .icon::before, .contact-info{
border-color:<?php echo $color ?> !important;
}
.custom--radio label::before{
border:2px solid <?php echo $color ?> !important;
}
.loader:after {
border-color: <?php echo $color ?> transparent <?php echo $color ?> transparent !important;
}
.form--control:focus,.select:focus{
border-color: <?php echo $color ?> !important;
box-shadow: 0 0 5px <?php echo $color ?>59;
}
.progress-wrap svg.progress-circle path{
stroke: <?php echo $color ?> !important;
}
.progress-wrap{
box-shadow: inset 0 0 0 2px <?php echo $color ?>33;
}
.pagination .page-item.active .page-link,.pagination .page-item .page-link:hover{
background-color:<?php echo $color ?> !important;
border-color: <?php echo $color ?> !important;
}
.track-item.active .icon{
background:<?php echo $color ?> !important;
}
.track-item .icon{
border: 3px solid <?php echo $color ?> !important;
}
.contact-info .icon{
background-color:<?php echo $color ?>36 !important;
}

.video-icon:hover{
    background-color:<?php echo $color ?>;
}

.video-icon{
    color:<?php echo $color ?>;
}

.pizza-size.active{
    background-color:<?php echo $color ?>;
}

.pizza-size{
    border-color: <?php echo $color ?>;
}