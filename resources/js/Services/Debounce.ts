export function debounce(fn: Function, wait: Number): Function{
    let timer;
    return function(...args){
        if(timer) {
            clearTimeout(timer); // clear any pre-existing timer
        }
        const context = this; // get the current context
        timer = setTimeout(()=>{
            console.log("debounce - calling callback");
            fn.apply(context, args); // call the function if time expires
        }, wait);
    }
}
