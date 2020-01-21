function initialize_datatable(id, url, columns){
    if ($("#"+id).length > 0) {
        $("#"+id).DataTable({
            processing: true,
            serverSide: true,
            ajax : url,
            columns : columns
        });
     }
}

function addTaskForm() {
    $(document).ready(function() {
        $("#add-error-bag").hide();
        $('#editTaskModal').modal('show');
    });
}