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
        <h4 class="modal-title">Employee Loans</h4>
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
        <div class="form-group">
            <label for="loan_type">Loan Type</label>
            <select class="form-control" id='loan_type' name='loan_type_id'>
                <option value="1">Vale</option>
                <option value="2">Salary</option>
                <option value="3">SSS</option>
            </select>
        </div>    
        <div class="form-group">
            <label for="loan_amount">Loan Amount</label>
            <input type="number" class="form-control" id="loan_amount" name="loan_amount" 
                placeholder="Enter amount">
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

