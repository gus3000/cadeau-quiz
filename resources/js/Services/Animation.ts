export function restartAnimation(element: HTMLElement, animationClass: string, delay:number = 0): void {
    element.classList.remove(animationClass);

    setTimeout(() => {
        void element.offsetWidth; //We force a reflow to trigger the animation

        element.classList.add(animationClass);
    }, delay);

}
