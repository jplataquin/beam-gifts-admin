import './bootstrap';


window.util = {};

util.imgToBlob = async function (img){
            
    let canvas = document.createElement('canvas');

    canvas.width    = img.width;
    canvas.height   = img.height;

    let ctx = canvas.getContext('2d');

    ctx.drawImage(img,0,0,img.width, img.height);

    return new Promise(function(resolve, reject) {
        canvas.toBlob((blob) => {

            resolve(blob);
        });
    });
}



window.util.$get = async (url,data) => {

    let status = '';
    
    return fetch(url+'?'+ new URLSearchParams(data),
    {
        headers: {
            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').content,
            "Accept": "application/json"
        },
        method: "GET"
    }).then((response) => {
        
        status = response.status;

        if(response.status == 401){
            return {
                    status:-1,
                    message:'Please sign in',
                    data:{}
            }
        };

        if(response.status == 500){

            console.error(response);
            return {
                    status:0,
                    message:'Something went wrong',
                    data:{}
            }
        };

        return response.json();
    }).catch(e=>{

        return {
            status:0,
            message:e.message,
            data:{
                httpStatus: status
            }
        }
    });
}

window.util.$post = async (url,params,headers) => {

    headers                 = headers ?? {};
    headers['X-CSRF-Token'] =  document.querySelector('meta[name="csrf-token"]').content
    
    let formData = new FormData();

    for(let key in params){
        formData.append(key,params[key]);
    }

    return fetch(url,
    {
        headers: headers,
        body: formData  ?? {},
        method: "POST"
    }).then((response) => {
       
        if(response.status == 401){
            return {
                    status:-1,
                    message:'Please sign in',
                    data:{}
            }
        };

        if(response.status == 500){

            console.error(response);
            return {
                    status:0,
                    message:'Something went wrong',
                    data:{}
            }
        };

        return response.json();
    }).catch(e=>{

        return {
            status:0,
            message:e,
            data:{}
        }
    });
}
