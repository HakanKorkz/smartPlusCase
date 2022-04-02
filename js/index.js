async function dataList(data="") {
    let resp;
    await fetch('backend/api.php',{
        method:"post",
        body:data
    })
        .then(response => resp = response.json())
        .then(data => resp = data);
    return resp
}

const apiList = document.getElementById("apiList");


dataList().then(r => {
    r.map(liste => {
        apiList.innerHTML += `<tr> 
             <th scope="row">${liste.date}</th>
             <th scope="row">${liste.totalSales}</th>
             <th scope="row">${liste.TotalTransactionAmount}</th>
             <th scope="row">${liste.WeightedAveragePrice}</th>
            </tr> 
`
    })
})
const button=document.querySelector("button[type='submit']");

button.addEventListener("click",()=>{
    apiList.innerHTML=""
    const formData=document.getElementById("formData")
        let dataInfo = new FormData(formData);

    dataList(dataInfo).then(r => {
        const apiList = document.getElementById("apiList");
        r.map(liste => {
            apiList.innerHTML += `<tr> 
             <th scope="row">${liste.date}</th>
             <th scope="row">${liste.totalSales}</th>
             <th scope="row">${liste.TotalTransactionAmount}</th>
             <th scope="row">${liste.WeightedAveragePrice}</th>
            </tr> 
`
        })
    })

    }
)
