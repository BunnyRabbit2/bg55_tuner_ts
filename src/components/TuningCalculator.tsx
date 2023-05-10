export interface TunerInputs {
    vehicleYear: string;
    vehicleMake: string;
    vehicleModel: string;

    gameVersion: "fm5" | "fm6" | "fm7" | "fh2" | "fh3" | "fh4"; // Needs setting correctly

    tuningType: "circuit" | "drag" | "drift" | "rally" | "offroad" | "buggy";

    isMetric: boolean;

    resetDrivetrain: boolean;
    resetFineTuning: boolean;

    tiresInput: TiresInput;

    suspensionInput: SuspensionInput;

    transmissionInput: TransmissionInput;
}

interface TiresInput {
    tireCompound: "stock" | "street" | "sport" | "race" | "drag" | "rally" | "offroad";
    frontTire: TireInput;
    rearTire: TireInput;
    isSquareTire: boolean; // Maybe get rid of this?
}

interface TireInput {
    width: number;
    aspectRatio: number;
    rim: number;
}

interface SuspensionInput {
    weight: number;
    weightPercentageFront: number;
    downforceFront: number;
    downforceRear: number;

    frontRideHeight: number;
    rearRideHeight: number;

    damperStiffness: "firmest" | "firmer" | "average" | "softer" | "softest";
    travelType: "shortest" | "shorter" | "average" | "longer" | "longest";

    fineTuning: SuspensionFineTuning;
}

interface SuspensionFineTuning {
    springMod: number;
    arbMod: number;
    reboundMod: number;
    bumpMod: number;
}

interface TransmissionInput {
    driveType: "fwd" | "rwd" | "awd";
    engineLayout: "front" | "mid" | "rear";
    power: number;
    torque: number;
    redline: number;
    topSpeed: number;
    gearNum: number;
    advancedDrivetrain: AdvancedDrivetrain;
}

interface AdvancedDrivetrain {
    finalDriveRatio: number;
    firstDriveRatio: number;
    firstDriveSpeed: number;
}

export class TuningCalculator {
    public calculateTuning(tunerInputs: TunerInputs) {
        const { vehicleYear, vehicleMake, vehicleModel, gameVersion, tuningType, isMetric, resetDrivetrain, resetFineTuning } = tunerInputs;

        let { weight, downforceFront, downforceRear, weightPercentageFront } = tunerInputs.suspensionInput;
        const { frontRideHeight, rearRideHeight, damperStiffness, travelType } = tunerInputs.suspensionInput;
        let { springMod, arbMod, reboundMod, bumpMod } = tunerInputs.suspensionInput.fineTuning;

        let { power, topSpeed, torque } = tunerInputs.transmissionInput;
        const { driveType, engineLayout, redline, gearNum } = tunerInputs.transmissionInput;
        let { finalDriveRatio, firstDriveRatio, firstDriveSpeed } = tunerInputs.transmissionInput.advancedDrivetrain;

        const { tireCompound, frontTire, rearTire, isSquareTire } = tunerInputs.tiresInput;

        if (resetFineTuning) {
            springMod = 1.0;
            arbMod = 1.0;
            reboundMod = 1.0;
            bumpMod = 1.0;
        }

        if (resetDrivetrain) {
            finalDriveRatio = 0;
            firstDriveRatio = 0;
            firstDriveSpeed = 0;
        }
        
        if (isMetric) {
            downforceFront *= 2.20462;
            downforceRear *= 2.20462;
            weight *= 2.20462;

            power += 1.34102;
            torque *= 0.7375621483695506;

            if (topSpeed !== 0) {
                topSpeed *= 0.621371;
            }
        }

        let powerToWeight = weight / power;

        let isOffroad = false;

        let fhArbMod = 1.0;
        let fhDampMod = 1.0;
        let fhSpringMod = 1.0;
        let damperDouble = false;

        if (gameVersion == "fh3" && (tuningType == "circuit" || tuningType == "drift" || tuningType == "drag")) {
            fhArbMod = 1.6;
            fhDampMod = 1.3;
        } else if (tuningType == "rally") {
            if (gameVersion == "fh3") {
                fhDampMod = 0.7;
                fhSpringMod = 0.75;
                damperDouble = true;
            } else {
                fhArbMod = 0.9;
                fhDampMod = 0.7;
                fhSpringMod = 0.75;
            }
        } else if (tuningType == "offroad") {
            if (gameVersion == "fh3") {
                fhDampMod = 0.7;
                fhSpringMod = 0.55;
                damperDouble = true;
            } else {
                fhArbMod = 0.8;
                fhDampMod = 0.7;
                fhSpringMod = 0.55;
            }
        } else if (tuningType == "buggy") {
            if (gameVersion == "fh3") {
                fhDampMod = 0.7;
                fhSpringMod = 0.32;
                damperDouble = true;
            } else {
                fhArbMod = 0.7;
                fhDampMod = 0.7;
                fhSpringMod = 0.32;
            }
        }

        // Setting front and rear weight calculations and other special vars
        const downforceTotal = downforceFront + downforceRear;
        weightPercentageFront /= 100.0;
        const weightPercentageRear = 1 - weightPercentageFront;
        const weightFront = (weight * weightPercentageFront) + downforceFront;
        const weightRear = (weight * weightPercentageRear) + downforceRear;

        const weightPercentageMod = weightPercentageFront != 0.5 ? (weightPercentageFront - 50) / 2 : 0;

        const weightPercentageModFront = weightPercentageFront > 0.5 ? 1 + (weightPercentageFront - 0.5) : 1 - (0.5 - weightPercentageFront);
        const weightPercentageModRear = weightPercentageRear < 0.5 ? 1 - (0.5 - weightPercentageFront) : 1 + (weightPercentageFront - 0.5);

        // Damper TRAVEL
        let reboundStiffnessMod = 2.0;
        let camberMod = 0.0;
        let castermod = 0.0

        if (travelType == "shortest") {
            reboundStiffnessMod = 1.7;
            camberMod += 0.2;
            castermod -= 0.2;
        } else if (travelType == "shorter") {
            reboundStiffnessMod = 1.85;
            camberMod += 0.1;
            castermod -= 0.1;
        } else if (travelType == "longer") {
            reboundStiffnessMod = 1.5;
            camberMod -= 0.1;
            castermod += 0.1;
        } else if (travelType == "longest") {
            camberMod -= 0.2;
            castermod += 0.2;
        }

        // STIFFNESS values and modifiers
        let springStiffnessMod = 1.0;
        let arbStiffnessMod = 1.0;
        let bumpStiffnessMod = 1.0;
        let reboundBase = 0.0; // Should be bumpbaseF * 1.5

        if (damperStiffness == "firmest") {
            springStiffnessMod = 1.1;
            arbStiffnessMod = 1.25;
            bumpStiffnessMod = 1.4;
        } else if (damperStiffness == "firmer") {
            springStiffnessMod = 1.05;
            arbStiffnessMod = 1.15;
            bumpStiffnessMod = 1.2;
        } else if (damperStiffness == "softer") {
            springStiffnessMod = 0.95;
            arbStiffnessMod = 0.85;
            bumpStiffnessMod = 0.9;
        } else if (damperStiffness == "softest") {
            springStiffnessMod = 0.9;
            arbStiffnessMod = 0.7;
            bumpStiffnessMod = 0.8;
        }

        // MIN/MAX checks
        if (springStiffnessMod > 2.0) springStiffnessMod = 1.0;
        if (arbStiffnessMod > 2.0) arbStiffnessMod = 1.0;
        if (reboundMod > 2.0) reboundStiffnessMod = 1.0;
        if (bumpStiffnessMod > 3.0) bumpStiffnessMod = 1.0;

        // Tire ratios
        const tireWidthAvg = (frontTire.width + rearTire.width) / 2.0;
        const tireFrontWidthRatio = frontTire.width / tireWidthAvg;
        const tireRearWidthRatio = rearTire.width / tireWidthAvg;

        // Set rear tire multiplier for brake balance calculations
        let tiredMulti = 0; // TODO: Workout what this is
        const tireWidthDiff = rearTire.width - frontTire.width;
        if (tireWidthDiff >= 20) tiredMulti += 1;
        if (tireWidthDiff >= 40) tiredMulti += 1;
        if (tireWidthDiff >= 60) tiredMulti += 1;
        if (tireWidthDiff >= 80) tiredMulti += 1;

        // Advanced Tire Calculations
        if (isMetric) {
            frontTire.rim *= 25.4;
            rearTire.rim *= 25.4;
        } else {
            frontTire.width /= 25.4;
            rearTire.width /= 25.4;
        }

        const frontTireHeight = frontTire.width * (frontTire.aspectRatio / 100);
        const rearTireHeight = rearTire.width * (rearTire.aspectRatio / 100);

        const frontTireDiameter = frontTireHeight * 2 + frontTire.rim;
        const frontTireRadiusInside = frontTire.rim / 2;
        const frontTireVolumeInside = 3.14159265359 * frontTireRadiusInside * frontTireRadiusInside * frontTire.width;
        const frontTireRadiusOutside = frontTireDiameter / 2;
        const frontTireVolumeOutside = 3.14159265359 * frontTireRadiusOutside * frontTireRadiusOutside * frontTire.width;
        
        const rearTireDiameter = rearTireHeight * 2 + rearTire.rim;
        const rearTireRadiusInside = rearTire.rim / 2;
        const rearTireVolumeInside = 3.14159265359 * rearTireRadiusInside * rearTireRadiusInside * rearTire.width;
        const rearTireRadiusOutside = rearTireDiameter / 2;
        const rearTireVolumeOutside = 3.14159265359 * rearTireRadiusOutside * rearTireRadiusOutside * rearTire.width;

        const frontTireCircumference = 2 * 3.14159265359 * frontTireRadiusOutside;
        const rearTireCircumference = 2 * 3.14159265359 * rearTireRadiusOutside;

        let frontTireVolume = 0;
        let rearTireVolume = 0;

        if (isMetric) {
            frontTireVolume = ((frontTireVolumeOutside - frontTireVolumeInside) / 1000) / 1000;
            rearTireVolume = ((rearTireVolumeOutside - rearTireVolumeInside) / 1000) / 1000;
        } else {
            frontTireVolume = (frontTireVolumeOutside - frontTireVolumeInside) / 1728;
            rearTireVolume = (rearTireVolumeOutside - rearTireVolumeInside) / 1728;
        }
    }
}