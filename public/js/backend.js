/* 

	DELETE ELEMENTS

*/

var delElements = document.getElementsByClassName('delete-el');
for (var i = 0; i < delElements.length; i++) {
    delElements[i].addEventListener('click', function(e) {
        let confir = confirm("Desea eliminar el elemento?");
        let object = e.target;
        if (confir) {
            object.nextElementSibling.submit();
        }
    });
}