export function restartAnimation(element: HTMLElement, animationClass: string): void {
    console.log("restarting animation on", element);
    element.classList.remove(animationClass);

    void element.offsetWidth; //We force a reflow to trigger the animation

    element.classList.add(animationClass);
}
