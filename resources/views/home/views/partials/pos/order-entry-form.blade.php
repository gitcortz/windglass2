
<div class="card card-primary card-outline">
    <div class="card-header d-flex p-0">
    <ul class="nav nav-pills p-2">
    <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">1</a></li>
        <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">+</a></li>
        <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">-</a></li>        
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
            ... <span class="caret"></span>
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
    </div><!-- /.card-header -->
    <div class="card-body">
        <div class="form-group">
            <label for="customer">Customer</label>
            <div class="input-group">
                <select class="form-control" id='customer' name='customer_id'>
                    <option value="0">Walk-in</option>
                </select>
                <div class="input-group-append">
                    <div class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <table class="table table-sm">
                    <thead>
                        <tr>
                        <th></th>
                        <th scope="col">Product</th>
                        <th scope="col">Price</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td></td>
                        <td>Mark</td>
                        <td>12.01</td>
                        <td>1</td>
                        <td>12.01</td>
                        </tr>
                        <tr>
                        <td></td>
                        <td>Mark</td>
                        <td>12.01</td>
                        <td>1</td>
                        <td>12.01</td>
                        </tr>
                        <tr>
                        <td></td>
                        <td>Mark</td>
                        <td>12.01</td>
                        <td>1</td>
                        <td>12.01</td>
                        </tr>
                    </tbody>
                </table>
                <div class="row mt-5">
                    <table class="table table-sm mt-3">                   
                        <tbody>
                            <tr>
                            <td></td>
                            <td>Subtotal</td>
                            <td>20.00</td>
                            <td>4 items</td>
                            </tr>
                            <tr>
                            <td></td>
                            <td>Discount</td>
                            <td>12.01</td>
                            <td>PHP</td>
                            </tr>
                            <tr>
                            <td></td>
                            <td>TOTAL</td>
                            <td>12.01</td>
                            <td>PHP</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2">
            The European languages are members of the same family. Their separate existence is a myth.
            For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ
            in their grammar, their pronunciation and their most common words. Everyone realizes why a
            new common language would be desirable: one could refuse to pay expensive translators. To
            achieve this, it would be necessary to have uniform grammar, pronunciation and more common
            words. If several languages coalesce, the grammar of the resulting language is more simple
            and regular than that of the individual languages.
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_3">
            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
            when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            It has survived not only five centuries, but also the leap into electronic typesetting,
            remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
            sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
            like Aldus PageMaker including versions of Lorem Ipsum.
            </div>
            <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
    </div><!-- /.card-body -->
    <div class="card-footer" >
        <input class="btn btn-default" data-dismiss="modal" type="button" value="Cancel">
        <button class="btn btn-info" id="btn-save" type="button" value="save">Payment</button>
    </div>
</div>
