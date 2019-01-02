<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar" data-widget="tree">
    <!-- sidebar: style can be found in sidebar.less -->`
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <?php
                if (Auth::user()->image)
                {
                    echo '<div class="pull-left image">
                <img src="'.asset("/uploads/profiles/".Auth::user()->image).'" class="img-circle" alt="User Image" />
                </div>';
                }
                else
                {
                    echo '<div class="pull-left image">
                <img src="'.asset("/bower_components/admin-lte/dist/img/user2-160x160.jpg").'" class="img-circle" alt="User Image" />
                </div>';
                }

            ?>
            <div class="pull-left info" >
                <p style="<?php echo (roles() == 'eurostar')?"margin-left: 15px;margin-top: 12px;": "" ?>">{{ Auth::user()->first_name }} {{Auth::user()->last_name }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <?php
        $value = '';

        if(Request::get('q') !== null && !empty(Request::get('q')) )
        {
            $value = $_GET['q'];
        }
        ?>
        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" value="{!! $value !!}" @if(isset($main_search) && $main_search == false) disabled @endif  placeholder="Search..."/>
                <span class="input-group-btn">

                  <button type='submit' name='search' id='search-btn' class="btn btn-flat" @if(isset($main_search) && $main_search == false) disabled @endif><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">DASHBOARD</li>
            <!-- Optionally, you can add icons to the links -->
            @if(roles() == 'super_admin' ||  roles() == 'admin'  ||  roles() == 'editor' )
                <li class="{{ (Request::segment(2) == 'articles') ? 'active' : '' }}"><a href="{{ url('/backend/articles') }}"><i class="fa fa-book"></i><span>Articles</span></a></li>
            @endif

            @if(roles() == 'super_admin' || roles() == 'admin')
                <li class="treeview {!! (Request::segment(2) == 'admins') ? 'menu-open' : '' !!}">
                    <a href="#">
                        <i class="fa fa-user" aria-hidden="true"></i><span>Administrator</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu " {!! (Request::segment(2) == 'admins') ? 'style="display: block"' : '' !!}>
                        <li class="{{ (Request::segment(2) == 'admins') ? 'active' : '' }}"><a href="{{ url('/backend/admins') }}"></i> Admins</a></li>
                    </ul>
                </li>
            @endif
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
