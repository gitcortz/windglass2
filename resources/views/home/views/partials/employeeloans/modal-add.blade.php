<style>
.ui-autocomplete {
  z-index:2147483647;
}
</style>
<div class="modal fade loanmodal-add" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content"> 
      <form id="loanform-add">   
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Employee Loan</h4>
      </div>
      <div class="modal-body">        
        <input type="hidden" name="employee_id" id="add_employee_id" />
        <div class="alert alert-danger d-none error-bag-add" id="error-bag">
            <ul id="error-list" class="error-list"></ul>
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
        <button type="button" class="btn btn-primary" id="btn-loan-add">Save</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

