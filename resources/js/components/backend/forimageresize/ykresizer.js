const ykresizer=(data, width, height)=>{
    return new Promise(resolve => {

        let imgval = data;
        let imgsize_w = width;
        let imgsize_h = height;
        let reader = new FileReader();
        reader.readAsDataURL(imgval);
        var resp = reader.onload = (event) => {
            let tmpimgurl = event.target.result;
            let img = document.createElement('img');
            img.src = tmpimgurl;
            img.onload = (e) => {
                let canvas = document.createElement('canvas');
                canvas.width = imgsize_w;
                canvas.height = imgsize_h;
                const contex = canvas.getContext('2d');
                contex.drawImage(img, 0, 0, canvas.width, canvas.height);
                let new_img = contex.canvas.toDataURL(imgval.type, 100);

                resolve(new_img);
            }
        }
    })
}

export default ykresizer;
