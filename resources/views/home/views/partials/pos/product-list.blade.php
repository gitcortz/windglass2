<style>
.img{
    float:right;
    display:inline-block;
    height: 44px;                /*Defines the height portion of the image we want to use*/
    background: url('http://www.w3schools.com/css/img_navsprites.gif') 0 0;
}
#one{
    width: 46px;                   /*Defines the width portion of the image we want to use*/
    background-position: 0 0;      /*Defines the background position (left 0px, top 0px)*/
}
.list-group-item{
    overflow: hidden;
}
</style>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">All</a></li>
        <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Cylinder</a></li>
        <li class=""><a href="#settings" data-toggle="tab" aria-expanded="false">Parts</a></li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                Empty Cylinder <span class="caret"></span>
            </a>
            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 40px, 0px);">
                <a class="dropdown-item" tabindex="-1" href="#">Action</a>
                <a class="dropdown-item" tabindex="-1" href="#">Another action</a>
                <a class="dropdown-item" tabindex="-1" href="#">Something else here</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" tabindex="-1" href="#">Separated link</a>
            </div>
        </li>
    </ul>
    <div class="tab-content">
        <div class="input-group">
            <input type="text" class="form-control">
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary btn-flat">
                <i class="fa fa-search"></i>
                </button>
            </span>
        </div>
        <hr />
        <div class="tab-pane active" id="activity">
            <div class="row">
                <div class="col-md-12">
                    <div class="list-group">
                    <a href="#" class="list-group-item d-flex justify-content-between align-items-center">
                  ss
                    </a>                    
                    <a href="#" class="list-group-item">
                        ONE<span id="one"  class="img"></span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        ONE<img src="https://s3.eu-central-1.amazonaws.com/bootstrapbaymisc/blog/24_days_bootstrap/don_quixote.jpg" 
                        class="img img-circle" />
                                         
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">Porta ac consectetur ac</a>
                    <a href="#" class="list-group-item list-group-item-action">Vestibulum at eros</a>
                    
                    </div>                
                </div>            
            </div>           
        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane" id="timeline">
       timeline
        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane" id="settings">
       form
        </div>
        <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
</div>
<!-- /.end -->
