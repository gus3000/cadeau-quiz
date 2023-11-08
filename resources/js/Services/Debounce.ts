export function debounce(fn: Function, wait: number): Function {
    let timer: number;
    return function (this: Object, ...args: any[]) {
        if (timer) {
            clearTimeout(timer); // clear any pre-existing timer
        }

        const context = this as Object; // get the current context
        timer = setTimeout(() => {
            console.log("debounce - calling callback");
            fn.apply(context, args); // call the function if time expires
        }, wait);
    }
}
