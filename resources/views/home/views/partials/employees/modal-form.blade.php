<div class="modal fade modal-addupdate" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content"> 
      <form id="form-addupdate">   
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Employee</h4>
      </div>
      <div class="modal-body">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li id="navtab_1" class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Details</a></li>
            <li id="navtab_2" class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Loans</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
              <input type="hidden" name="id" id="_id" />
              <div class="row">
                  <div class="alert alert-danger d-none" id="error-bag">
                      <ul id="error-list"></ul>
                  </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="name">First Name</label>
                      <input type="text" class="form-control" id="first_name" name="first_name" 
                          required placeholder="Enter First name">
                  </div>
                  <div class="form-group">
                      <label for="name">Last Name</label>
                      <input type="text" class="form-control" id="last_name" name="last_name" 
                          required placeholder="Enter Last name">
                  </div>
                  <div class="form-group">
                      <label for="city">Employee Type</label>
                      <select class="form-control" id='employeetype' name='employeetype_id'></select>
                  </div>
                  <div class="form-group">
                      <label for="address">Address</label>
                      <input type="text" class="form-control" id="address" name="address" 
                          placeholder="Enter address">
                  </div>
                  <div class="form-group">
                      <label for="city">City</label>
                      <select class="form-control" id='city' name='city_id'></select>
                  </div>
                  <div class="form-group">
                      <label for="notes">Notes</label>
                      <input type="text" class="form-control" id="notes" name="notes" 
                          placeholder="Enter notes">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="phone">Phone</label>
                      <input type="text" class="form-control" id="phone" name="phone" 
                          placeholder="Enter phone">
                  </div>
                  <div class="form-group">
                      <label for="mobile">Mobile</label>
                      <input type="text" class="form-control" id="mobile" name="mobile" 
                          placeholder="Enter mobile">
                  </div>
                  <div class="form-group">
                      <label for="discount">Base Salary</label>
                      <input type="number" class="form-control" id="base_salary" name="base_salary" 
                          placeholder="Enter base_salary">
                  </div>
                  <div class="form-group">
                      <label for="name">Biometrics</label>
                      <input type="text" class="form-control" id="biometrics_id" name="biometrics_id" 
                          placeholder="Enter Biometrics ID">
                  </div>
                  <div class="form-group">
                      <label for="address">Hire Date</label>
                      <input type="date" class="form-control" id="hire_date" name="hire_date" 
                          placeholder="Enter hire date">
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab_2">
              <table id="dataTableLoan" class="table table-bordered table-striped dataTable" role="grid" style="width:100%">
                      <thead>
                          <tr>
                              <th>Id</th>
                              <th>Employee</th>
                              <th>Loan Type</th>
                              <th>Status</th>
                              <th>Amount</th>
                              <th>Action</th>
                          </tr>
                      </thead>                   
                </table>
            </div>
          </div>
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