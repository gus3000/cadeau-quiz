import {ArcRotateCamera, Engine, HemisphericLight, Scene, SceneLoader, Vector3} from "@babylonjs/core";
import "@babylonjs/core/Loading/loadingScreen";
import "@babylonjs/loaders/glTF";
import "@babylonjs/core/Materials/standardMaterial";
import "@babylonjs/core/Materials/Textures/Loaders/envTextureLoader";
import "@babylonjs/core/Animations/animatable"

const createScene = (canvas, fpsCallback) => {
    const engine = new Engine(canvas);
    const scene = new Scene(engine);

    scene.autoClear = false;

    // scene.createDefaultCameraOrLight(true, true, true);
    // scene.createDefaultEnvironment();

    SceneLoader.ImportMesh("", "/glb/", "flask.glb", scene, function (meshes) {

    });

    const camera = new ArcRotateCamera(
        "my second camera",
        0,
        Math.PI / 3,
        5,
        new Vector3(0, 0, 0),
        scene
    );
    camera.setTarget(Vector3.Zero());
    camera.attachControl(canvas, true);
    camera.useFramingBehavior = true;

    const light = new HemisphericLight(
        "light",
        new Vector3(0, 1, 0),
        scene
    );

    engine.runRenderLoop(() => {
        scene.render();

        // boxGreen.rotation.y += 0.01;

        if (fpsCallback) {
            fpsCallback(engine.getFps().toFixed());
        }
    });
};

export {createScene};