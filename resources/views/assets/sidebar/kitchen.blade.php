<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Divider -->
        <div id="sidebar-menu">
            <ul>


                <li class="">
                    <a href="{{url('/home')}}" class="waves-effect"><i class="ti-home"></i> <span> Dashboard </span> </a>
                </li>

                <li class="">
                    <a href="{{url('/cooking-history')}}" class="waves-effect"><i class="ti-home"></i> <span> History </span> </a>
                </li>
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="ti-notepad"></i> <span> Orders </span>
                        <span class="menu-arrow"></span> </a>
                    <ul class="list-unstyled">
                        <li><a href="{{url('/order')}}">New Order</a></li>
                        <li><a href="{{url('/all-order')}}">All Order</a></li>
                        <li><a href="{{url('/non-paid-order')}}">Non paid Order</a></li>
                    </ul>
                </li><li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><span>Expense</span> <span class="menu-arrow"></span></a>
                    <ul style="">
                        {{--<li><a href="{{url('/new-purses')}}"><span>New Purses</span></a></li>--}}
                        <li><a href="{{url('/add-expense')}}"><span>Add Expense</span></a></li>
                        <li><a href="{{url('/all-expanse')}}"><span>All Expense</span></a></li>
                    </ul>
                </li>


            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
