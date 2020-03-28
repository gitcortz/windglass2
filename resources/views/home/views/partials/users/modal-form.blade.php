<style>
.mt-1 {margin-top:10px;}
</style>
<div class="modal fade modal-addupdate" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content"> 
      <form id="form-addupdate">   
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Users</h4>
      </div>
      <div class="modal-body">        
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">User</a></li>
            <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Branches</a></li>
            <li><a href="#tab_3" data-toggle="tab" style="display:none">Roles</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
              <input type="hidden" name="id" id="_id" />
                <div class="alert alert-danger d-none" id="error-bag">
                    <ul id="error-list"></ul>
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" 
                        required placeholder="Enter name">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" 
                        required placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" 
                        placeholder="Enter password">
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select class="form-control" id="role" name="role" >
                      <option value="user">User</option>
                      <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="form-group">
                  <label>
                    <div class="icheckbox_flat-green" aria-checked="true" aria-disabled="false" style="position: relative;">
                      <input type="checkbox" id="active" name="active" checked="" style="position: absolute; opacity: 0;">
                      <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                    </div>
                    &nbsp; Active
                  </label>
                </div>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2">
              Branches
              <div class="row mt-1" id="branch_selection">
                                  
              </div>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_3">
              Roles
            </div>
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div>     
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="btn-save">Save</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

