function tableSearch(){
    let input, filter, table, tr, td, h, txtValue;

    //Initializing Var
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = document.getElementsByTagName("tr");

    for(let h = 0; h < tr.length; h++){
        td = tr[h].getElementsByTagName("td")[0];
        if(td){
            txtValue = td.textContent || td.innerText;
            if(txtValue.toUpperCase().indexOf(filter) > -1){
                tr[h].style.display = "";
            }
            else {
                tr[h].style.display = "none";
            }
        }
    }
}