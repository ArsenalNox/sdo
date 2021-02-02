const form = document.querySelector('form');

form.addEventListener('submit', (event) => {
    event.preventDefault();

    // console.log("123")
    window.inputs = document.querySelectorAll('input');

    // const dataReqest = new FormData()

    // for (let i of inputs) {
    //     dataReqest.append(i.name, i.value)
    // }

    // sended(dataReqest);
    // console.log(dataReqest)
})

// let sended = async(data) => {

//     fetch('/registration/', {
//             method: 'POST',
//             body: data,
//         })
//         .then(async(response) => {
//             let dataResponse = await response.json();
//             return dataResponse;
//         })
//         .then((data) => {
//             console.log(data.data);
//             if (data.type == "success") {
//                 window.location.href="/profile/"
//             }else {
//                 alert(data.data)
//             }
//         })
//         .catch((error) => {
//             console.log(error);
//         });
// }