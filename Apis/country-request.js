let config = {
    headers:new Headers(
        {"Content-Type": "application/json; charset:utf8"}
    ), 
};
const postData = async(data)=>{
    config.method = "POST";
    config.body = JSON.stringify(data);
    let res = await ( await fetch("../controllers/Country/insert_data.php",config)).text();
    return res;
}

export{
    postData
}