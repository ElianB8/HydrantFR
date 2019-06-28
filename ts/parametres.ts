const Main = () : void => {
    const save_param : HTMLElement = document.getElementById("save_param");
    save_param.addEventListener('click',formValid);
}

const formValid = () : void => {
    const param_passwd : HTMLElement = document.getElementById("param_passwd");
    const conf_param_passwd : HTMLElement = document.getElementById("conf_param_passwd");

    const param_passwd_value : any = param_passwd.value;
    const conf_param_passwd_value : any = conf_param_passwd.value;

    if(isNaN(param_passwd_value) && isNaN(conf_param_passwd_value)){
        alert("Seul les chiffres sont accepté.");
    }
}


window.addEventListener('load',Main);