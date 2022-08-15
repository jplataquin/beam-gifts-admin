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