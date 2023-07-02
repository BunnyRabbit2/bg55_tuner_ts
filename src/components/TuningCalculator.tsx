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

        const tireHeightFront = frontTire.width * (frontTire.aspectRatio / 100);
        const tireHeightRear = rearTire.width * (rearTire.aspectRatio / 100);

        const tireDiameterFront = tireHeightFront * 2 + frontTire.rim;
        const tireRadiusInsideFront = frontTire.rim / 2;
        const tireVolumeInsideFront = 3.14159265359 * tireRadiusInsideFront * tireRadiusInsideFront * frontTire.width;
        const tireRadiusOutsideFront = tireDiameterFront / 2;
        const tireVolumeOutsideFront = 3.14159265359 * tireRadiusOutsideFront * tireRadiusOutsideFront * frontTire.width;
        
        const tireDiameterRear = tireHeightRear * 2 + rearTire.rim;
        const tireRadiusInsideRear = rearTire.rim / 2;
        const tireVolumeInsideRear = 3.14159265359 * tireRadiusInsideRear * tireRadiusInsideRear * rearTire.width;
        const tireRadiusOutsideRear = tireDiameterRear / 2;
        const tireVolumeOutsideRear = 3.14159265359 * tireRadiusOutsideRear * tireRadiusOutsideRear * rearTire.width;

        const frontTireCircumference = 2 * 3.14159265359 * tireRadiusOutsideFront;
        const rearTireCircumference = 2 * 3.14159265359 * tireRadiusOutsideRear;

        let tireVolumeFront = 0;
        let tireVolumeRear = 0;

        if (isMetric) {
            tireVolumeFront = ((tireVolumeOutsideFront - tireVolumeInsideFront) / 1000) / 1000;
            tireVolumeRear = ((tireVolumeOutsideRear - tireVolumeInsideRear) / 1000) / 1000;
        } else {
            tireVolumeFront = (tireVolumeOutsideFront - tireVolumeInsideFront) / 1728;
            tireVolumeRear = (tireVolumeOutsideRear - tireVolumeInsideRear) / 1728;
        }

        // Suspension Tuning

        // SPRING RATE
        const weightMod = 0.85; //Used to dial in the spring rates
        const springRate = (weight * weightMod * springStiffnessMod * fhSpringMod) / 2;
        let springRateFront = (springRate * weightPercentageFront) + (downforceFront / 10);
        let springRateRear = (springRate - springRateFront) + (downforceRear / 10)

        const springRateMetricMod = 0.453592 * 0.3937;

        if (isMetric) {
            springRateFront *= springRateMetricMod;
            springRateRear *= springRateMetricMod;
        }

        // Apply Spring User Fine-Tuning Stiffness Modifier
        springRateFront *= springMod;

        // --------------------------------------------------
        // Determine ARB
        // Intentionally calculated with reveresed weight R/F
        // --------------------------------------------------
        // FM3-7 & FH2 ARB Range = 1.0-40.0
        // FH3 ARB Range = 1.0 to 65.0

        const maxArb = gameVersion == 'fh3' ? 65.0 : 40.0;
        const minArb = 1.0;

        // Setting front base ARB
        let arbBaseFront = isOffroad ? weightFront * 0.006 * fhArbMod : 7.0;

        // Adjusting for vehicle weight
        const arbWeightMod = 0
        
        let weightCalc = weight;
        while (weightCalc > 2750) {
            arbBaseFront += 0.1;
            weightCalc -= 100;
        }
        while (weightCalc < 2500) {
            arbBaseFront -= 0.1;
            weightCalc += 100
        }

        // Calculate rear ARB
        let arbBaseRear = arbBaseFront * 0.75; // RWD as default
        if (driveType == 'awd') arbBaseRear = arbBaseFront * 0.875;
        if (driveType == 'fwd') arbBaseRear = arbBaseFront * 1.125;

        // Adjusting ARB for weight bias
        let weightPercentageCalc = weightPercentageFront;
        if (weightPercentageCalc > 50) {
            arbBaseFront += 0.27;
            arbBaseRear -= 0.27;
            weightPercentageCalc -= 1;
        }
        if (weightPercentageCalc < 50) {
            arbBaseFront -= 0.27;
            arbBaseRear += 0.27;
            weightPercentageCalc += 1;
        }

        // Setting ARBs
        let arbFront = arbBaseFront * arbStiffnessMod;
        let arbRear = arbBaseRear * arbStiffnessMod;

        // Setting ARB Modifiers
        let arbLayout = 0.0
        if (engineLayout == 'mid') arbLayout = 0.2;
        else if (engineLayout == 'rear') arbLayout = 0.4;

        const arbTireMod = 1.85;
        if (tireCompound == 'drag') arbMod = arbTireMod + 0.11;
        else if (tireCompound == 'stock') arbMod = arbTireMod + 0.11;
        else if (tireCompound == 'street') arbMod = arbTireMod + 0.07;
        else if (tireCompound == 'sport') arbMod = arbTireMod + 0.04;
        else if (tireCompound == 'offroad') arbMod = arbTireMod + 0.07;
        else if (tireCompound == 'rally') arbMod = arbTireMod + 0.04;
        else if (tireCompound == 'race') arbMod = arbTireMod;

        arbFront *= arbMod;
        arbRear = arbRear * arbMod + arbLayout;
        // Apply ARB User Fine-Tuning Stiffness Modifier
        arbFront *= arbStiffnessMod;
        arbRear *= arbStiffnessMod;

        // Checking for Min-Max values
        arbBaseFront = Math.max(Math.min(arbBaseFront, maxArb), minArb);
        arbBaseRear = Math.max(Math.min(arbBaseRear, maxArb), minArb);

        // -----------------------
        // Determin Rebound & Bump
        // -----------------------
    }
}