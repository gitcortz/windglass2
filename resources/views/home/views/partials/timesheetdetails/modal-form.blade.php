<style>
.ui-autocomplete {
  z-index:2147483647;
}
</style>
<div class="modal fade modal-addupdate" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content"> 
      <form id="form-addupdate">   
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Timesheet Detail</h4>
      </div>
      <div class="modal-body">        
        <input type="hidden" name="id" id="_id" />
        <div class="alert alert-danger d-none" id="error-bag">
            <ul id="error-list"></ul>
        </div>
        <div class="form-group">
            <input type="hidden" id="employee_id" name="employee_id" />
            <label for="employee_autocomplete">Employee</label>
            <input type="text" class="form-control" id="employee_autocomplete" name="employee_autocomplete" 
                placeholder="Enter employee">
        </div>
        <div class="form-group datetimepicker">
            <label for="name">Time In (2000-01-01 00:00:00)</label>
            <input type="text" class="form-control" id="time_in" name="time_in" 
                required placeholder="Enter time-in">
        </div>
        <div class="form-group datetimepicker">
            <label for="name">Time Out </label><span> (2000-01-01 00:00:00) </span>
            <input type="text" class="form-control" id="time_out" name="time_out" 
                required placeholder="Enter time-out">
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

<div class="modal fade modal-upload" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content"> 
      <form id="form-upload" enctype="multipart/form-data" >   
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Timesheet Upload</h4>
      </div>
      <div class="modal-body">        
        <div class="alert alert-danger d-none" id="upload-error-bag">
            <ul id="upload-error-list"></ul>
        </div>       
        <div class="form-group datetimepicker">
            <label for="name">File (csv)</label>
            <input type="file" class="form-control" id="select_file" name="select_file" data-buttonText="Browse" />
        </div>     
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="btn-upload">Upload</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


