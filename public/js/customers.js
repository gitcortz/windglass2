$(document).ready(function() {
    var crud = new Crud();
    crud.init(_component, 
        [
            {data: "id", name : "id"},
            {data: "name", name : "name"},
            {data: "email", name : "email"},
            {data: "action_btns", name : "action_btns"},
        ]
    );
});
