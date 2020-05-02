<div class="modal fade modal-addupdate" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content"> 
      <form id="form-addupdate">   
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Expenses</h4>
      </div>
      <div class="modal-body">        
        <input type="hidden" name="id" id="_id" />
        <div class="alert alert-danger d-none" id="error-bag">
            <ul id="error-list"></ul>
        </div>
        <div class="form-group ">
            <label for="name">Expense date</label>
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div> 
              <input class="form-control" id="expense_date" name="expense_date" placeholder="YYYY-MM-DD" type="text"/>
            </div>            
        </div>
        <div class="form-group">
            <label for="name">Payee</label>
            <input type="text" class="form-control" id="payee" name="payee" 
                required placeholder="Enter payee">                
        </div>
        <div class="form-group">
            <label for="name">Particulars</label>
            <input type="text" class="form-control" id="particulars" name="particulars" 
                required placeholder="Enter particulars">
        </div>       
        <div class="form-group">
            <label for="name">Amount</label>
            <input type="text" class="form-control" id="amount" name="amount" value="0"
                required placeholder="Enter amount">
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

