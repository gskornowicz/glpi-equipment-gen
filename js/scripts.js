$(document).ready(function() {
    document.getElementById('add_validate').onchange = function() {
    document.getElementById('ticket_id').disabled = !this.checked;
};
});

$(document).ready(function() {
    if(document.getElementById('add_validate').checked == true)
       document.getElementById('ticket_id').disabled = false; 

});