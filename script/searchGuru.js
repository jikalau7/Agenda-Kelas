function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
 }

 function filterFunction() {
     var input, filter, ul, li, a, i;
     input = document.getElementById("myInput");
     filter = input.value.toUpperCase();
     div = document.getElementById("myDropdown");
     a = div.getElementsByTagName("a");
     for (i = 0; i < a.length; i++) {
         txtValue = a[i].textContent || a[i].innerText;
         if (txtValue.toUpperCase().indexOf(filter) > -1) {
         a[i].style.display = "";
         } else {
         a[i].style.display = "none";
         }
     }
 }
 function autofill_choose(id_guru, nama_guru) {
     document.getElementById('id_guru').value = id_guru;
     document.getElementById('nama_guru').value = nama_guru;
     myFunction();
 }
 function empty() {
     var value = "0";
     var value_nam = "--Please Choose--";
     document.getElementById('nama_guru').value = value_nam;
     document.getElementById('id_guru').value = value;
 }