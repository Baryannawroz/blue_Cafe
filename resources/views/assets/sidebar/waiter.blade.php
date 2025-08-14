<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Divider -->
        <div id="sidebar-menu">
            <ul>

                <li class="text-muted menu-title">Navigation</li>

                <li class="">
                    <a href="{{url('/home')}}" class="waves-effect"><i class="ti-home"></i> <span> Dashboard </span>
                    </a>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="ti-notepad"></i> <span> Orders </span>
                        <span class="menu-arrow"></span> </a>
                    <ul class="list-unstyled">
                        <li><a href="{{url('/order')}}">New Order</a></li>
                        <li><a href="{{url('/my-orders')}}">My Order</a></li>
                    </ul>
                </li>

                <li class="hidden">
                    <a href="{{url('/kitchen-status')}}" class="waves-effect"><i class="icon icon-fire"></i> <span>
                            Kitchen Status </span> </a>
                </li>
                </li>
                    <li class="has_sub">
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
