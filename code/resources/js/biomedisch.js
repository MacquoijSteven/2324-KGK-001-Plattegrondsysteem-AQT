const gewichtInput = document.getElementById('biomedisch-gewicht');
const temperatuurInput = document.getElementById('biomedisch-temperatuur');

//doorsturen van het gewicht van een dier
gewichtInput.addEventListener("change", function() {
    const currentDate = new Date();
    const formattedDate = currentDate.toISOString().slice(0, 19).replace("T", " ");
    const changedElement = event.target;
    const newValue = changedElement.value;
    const inputType = gewichtInput.getAttribute('name');
    const dierid = gewichtInput.getAttribute("data-dierid");
    window.location.href = "checkitem/" + newValue + "/" + inputType + "/" + dierid + "/" + formattedDate; 
});

//doorsturen van de temperatuur van een dier
temperatuurInput.addEventListener("change", function() {
    const currentDate = new Date();
    const formattedDate = currentDate.toISOString().slice(0, 19).replace("T", " ");
    const changedElement = event.target;
    const newValue = changedElement.value;
    const inputType = temperatuurInput.getAttribute('name');
    const dierid = temperatuurInput.getAttribute("data-dierid");
    window.location.href = "checkitem/" + newValue + "/" + inputType + "/" + dierid + "/" + formattedDate; 
});
