const form = document.querySelector('form');

form.addEventListener('submit', (event) => {
    event.preventDefault();
    window.students = document.querySelectorAll('.item');
    window.group = document.querySelector('[name="GROUP_STUDENT_ID"]').value;
    const dataReqest = new FormData();
    window.students_arr = [];
    for (let student of students) {
        let fname = student.querySelector('[name="NAME"]').value;
        let mname = student.querySelector('[name="MIDDLE_NAME"]').value;
        let lname = student.querySelector('[name="LAST_NAME"]').value;
        if(fname != '' && mname != '' && lname != '')
        {
            let student_arr = {fname: fname, lname: lname, mname: mname};
            window.students_arr.push(student_arr);
        }
    }
    dataReqest.append('students', JSON.stringify(window.students_arr));
    dataReqest.append('group', window.group);
    console.log(window.students_arr);
    console.log(window.group);
    sended(dataReqest);
})

let sended = async(data) => {

    fetch('/sdo/admin.php', {
            method: 'POST',
            body: data,
        })
        .then(async(response) => {
            let dataResponse = await response.json();
            return dataResponse;
        })
        .then((data) => {
            console.log(data.data);
            if (data.type == "success") {
                location.reload()
            }else {
                alert(data.data)
            }
        })
        .catch((error) => {
            console.log(error);
        });
}