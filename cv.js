function addNewField1() {
    let newNode = document.createElement('textarea');
    newNode.classList.add('form-control');
    newNode.classList.add('weField');
    newNode.setAttribute('rows', 3);
    newNode.classList.add('mt-2');

    let weOb = document.getElementById('we');
    let weAddButtonOb = document.getElementById('weAddButton');

    weOb.insertBefore(newNode, weAddButtonOb);
}

function addNewField2() {
    let newNode = document.createElement('textarea');
    newNode.classList.add('form-control');
    newNode.classList.add('edField');
    newNode.setAttribute('rows', 3);
    newNode.classList.add('mt-2');

    let edOb = document.getElementById('ed');
    let edAddButtonOb = document.getElementById('edAddButton');

    edOb.insertBefore(newNode, edAddButtonOb);
}

function addNewField3() {
    let newNode = document.createElement('textarea');
    newNode.classList.add('form-control');
    newNode.classList.add('ceField');
    newNode.setAttribute('rows', 3);
    newNode.classList.add('mt-2');

    let ceOb = document.getElementById('ce');
    let ceAddButtonOb = document.getElementById('ceAddButton');

    ceOb.insertBefore(newNode, ceAddButtonOb);
}

function generateCv() {
    // Name field
    let nameField = document.getElementById('nameField').value;
    let nameT1 = document.getElementById('nameT1');

    nameT1.innerHTML = nameField;
    document.getElementById('nameT2').innerHTML = nameField;

    // Contact field
    document.getElementById('contactT').innerHTML = document.getElementById('contactField').value;

    // Email field
    document.getElementById('emailT').innerHTML = document.getElementById('emailField').value;

    // Address field
    document.getElementById('addT1').innerHTML = document.getElementById('addressField').value;

    // Linkedin field
    document.getElementById('lkT').innerHTML = document.getElementById('linkedinField').value;

    // Github field
    document.getElementById('gitT').innerHTML = document.getElementById('gitField').value;

    // Facebook field
    document.getElementById('fbT').innerHTML = document.getElementById('fbField').value;

    // Portfolio/Website field
    document.getElementById('stT').innerHTML = document.getElementById('stField').value;

    // Objective field
    document.getElementById('objectiveT').innerHTML = document.getElementById('objField').value;

    // Work experience
    let workExps = document.getElementsByClassName('weField'); // Getting objects of weField
    let str = '';

    for (let e of workExps) {
        str = str + `<li> ${e.value} </li>`;
    }
    document.getElementById('weT').innerHTML = str;

    // Education qualification
    let eduQua = document.getElementsByClassName('edField'); // Getting objects of edField
    let str1 = '';

    for (let e of eduQua) {
        str1 = str1 + `<li> ${e.value} </li>`;
    }
    document.getElementById('edT').innerHTML = str1;

    // Certifications
    let cerT = document.getElementsByClassName('ceField'); // Getting objects of ceField
    let str2 = '';

    for (let e of cerT) {
        str2 = str2 + `<li> ${e.value} </li>`;
    }
    document.getElementById('cerT').innerHTML = str2;

    // Hide the form and footer, show the template
    document.getElementById('resume-form').style.display = 'none';
    document.getElementById('footer').style.display = 'none';
    document.getElementById('resume-template').style.display = 'block';

    // Image field
    let fileInput = document.getElementById('imgField');
    let file = fileInput.files[0]; // Getting the first (index at 0) file

    if (file) {
        let reader = new FileReader();

        reader.readAsDataURL(file);

        // Set the image to the template
        reader.onloadend = function () {
        document.getElementById('imgT').src = reader.result;

            // Call printCv function after setting the image
        };
    }            //printCv();
    //else {
        // If no image is selected, proceed to print without an image
       // printCv();
    //}
}

// Print CV function
function printCv() {
    const resumePDF = document.getElementById("resume-template");
    var opt = {
        top: 1,
        bottom: 0,
        filename: 'myfile.pdf',
        image: { type: 'jpeg', quality: 1 },
        html2canvas: { scale: 1 },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' },
        pagebreak: { mode: 'css', before: '#resume-template' }
    };
    html2pdf().from(resumePDF).set(opt).save();
}