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
    tireFront: TireInput;
    tireRear: TireInput;
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

    rideHeightFront: number;
    rideHeightRear: number;

    damperStiffness: "firmest" | "firmer" | "average" | "softer" | "softest";
    travelType: "shortest" | "shorter" | "average" | "longer" | "longest";

    fineTuning: SuspensionFineTuning;
}

interface SuspensionFineTuning {
    springModFT: number;
    arbModFT: number;
    reboundModFT: number;
    bumpModFT: number;
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

interface ImperialToMetricConversion {
    weight: number;
    power: number;
    torque: number;
    topSpeed: number;
    pressure: number;
}

export interface TunerOutputs {
    tirePressureFront: number;
    tirePressureRear: number;
    gearRatios: GearRatios;
    alignment: AlignmentSettings;
    suspension: SuspensionSettings;
    brakeBalance: number;
    brakeForce: number;
    differential: DifferentialSettings;
}

interface GearRatios {
    finalDrive: number;
    ratio1: number;
    ratio2: number;
    ratio3: number;
    ratio4: number;
    ratio5: number;
    ratio6: number;
    ratio7: number;
    ratio8: number;
    ratio9: number;
    ratio10: number;
    ratio11: number;
}

interface AlignmentSettings {
    camberFront: number;
    camberRear: number;
    toeFront: number;
    toeRear: number;
    caster: number;
    steeringAngle: number | 'n/a';
}

interface SuspensionSettings {
    arbFront: number;
    arbRear: number;
    springFront: number;
    springRear: number;
    reboundFront: number;
    reboundRear: number;
    bumpFront: number;
    bumpRear: number;
}

interface DifferentialSettings {
    accFront: number;
    accRear: number;
    deccFront: number;
    deccRear: number;
    centerBalance: number;
}

export class TuningCalculator {
    public calculateTuning(tunerInputs: TunerInputs) {
        const { vehicleYear, vehicleMake, vehicleModel, gameVersion, tuningType, isMetric, resetDrivetrain, resetFineTuning } = tunerInputs;

        let { weight, downforceFront, downforceRear, weightPercentageFront } = tunerInputs.suspensionInput;
        const { rideHeightFront, rideHeightRear, damperStiffness, travelType } = tunerInputs.suspensionInput;
        let { springModFT, arbModFT, reboundModFT, bumpModFT } = tunerInputs.suspensionInput.fineTuning;

        let { power, topSpeed, torque } = tunerInputs.transmissionInput;
        const { driveType, engineLayout, redline, gearNum } = tunerInputs.transmissionInput;
        let { finalDriveRatio, firstDriveRatio, firstDriveSpeed } = tunerInputs.transmissionInput.advancedDrivetrain;

        const { tireCompound, tireFront: frontTire, tireRear: rearTire, isSquareTire } = tunerInputs.tiresInput;

        if (resetFineTuning) {
            springModFT = 1.0;
            arbModFT = 1.0;
            reboundModFT = 1.0;
            bumpModFT = 1.0;
        }

        if (resetDrivetrain) {
            finalDriveRatio = 0;
            firstDriveRatio = 0;
            firstDriveSpeed = 0;
        }

        const toMetricConv: ImperialToMetricConversion = {
            weight: 2.20462,
            power: 1.34102,
            torque: 0.7375621483695506,
            topSpeed: 0.621371,
            pressure: 0.0689475729
        }

        if (isMetric) {
            downforceFront *= toMetricConv.weight;
            downforceRear *= toMetricConv.weight;
            weight *= toMetricConv.weight;

            power += toMetricConv.power;
            torque *= toMetricConv.torque;

            if (topSpeed !== 0) {
                topSpeed *= toMetricConv.topSpeed;
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
        let casterMod = 0.0;

        if (travelType == "shortest") {
            reboundStiffnessMod = 1.7;
            camberMod += 0.2;
            casterMod -= 0.2;
        } else if (travelType == "shorter") {
            reboundStiffnessMod = 1.85;
            camberMod += 0.1;
            casterMod -= 0.1;
        } else if (travelType == "longer") {
            reboundStiffnessMod = 1.5;
            camberMod -= 0.1;
            casterMod += 0.1;
        } else if (travelType == "longest") {
            camberMod -= 0.2;
            casterMod += 0.2;
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
        if (reboundModFT > 2.0) reboundStiffnessMod = 1.0;
        if (bumpStiffnessMod > 3.0) bumpStiffnessMod = 1.0;

        // Tire ratios
        const tireWidthAvg = (frontTire.width + rearTire.width) / 2.0;
        const tireWidthRatioFront = frontTire.width / tireWidthAvg;
        const tireWidthRatioRear = rearTire.width / tireWidthAvg;

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
        const tireVolumeInsideFront = Math.PI * tireRadiusInsideFront * tireRadiusInsideFront * frontTire.width;
        const tireRadiusOutsideFront = tireDiameterFront / 2;
        const tireVolumeOutsideFront = Math.PI * tireRadiusOutsideFront * tireRadiusOutsideFront * frontTire.width;
        
        const tireDiameterRear = tireHeightRear * 2 + rearTire.rim;
        const tireRadiusInsideRear = rearTire.rim / 2;
        const tireVolumeInsideRear = Math.PI * tireRadiusInsideRear * tireRadiusInsideRear * rearTire.width;
        const tireRadiusOutsideRear = tireDiameterRear / 2;
        const tireVolumeOutsideRear = Math.PI * tireRadiusOutsideRear * tireRadiusOutsideRear * rearTire.width;

        const tireCircumferenceFront = 2 * Math.PI * tireRadiusOutsideFront;
        const tireCircumferenceRear = 2 * Math.PI * tireRadiusOutsideRear;

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
        const springWeightMod = 0.85; //Used to dial in the spring rates
        const springRateTotal = (weight * springWeightMod * springStiffnessMod * fhSpringMod) / 2;
        let springRateFront = (springRateTotal * weightPercentageFront) + (downforceFront / 10);
        let springRateRear = (springRateTotal - springRateFront) + (downforceRear / 10)

        const springRateMetricMod = 0.453592 * 0.3937;

        if (isMetric) {
            springRateFront *= springRateMetricMod;
            springRateRear *= springRateMetricMod;
        }

        // Apply Spring User Fine-Tuning Stiffness Modifier
        springRateFront *= springModFT;
        springRateRear *= springModFT;

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
        if (tireCompound == 'drag') arbModFT = arbTireMod + 0.11;
        else if (tireCompound == 'stock') arbModFT = arbTireMod + 0.11;
        else if (tireCompound == 'street') arbModFT = arbTireMod + 0.07;
        else if (tireCompound == 'sport') arbModFT = arbTireMod + 0.04;
        else if (tireCompound == 'offroad') arbModFT = arbTireMod + 0.07;
        else if (tireCompound == 'rally') arbModFT = arbTireMod + 0.04;
        else if (tireCompound == 'race') arbModFT = arbTireMod;

        arbFront *= arbModFT;
        arbRear = arbRear * arbModFT + arbLayout;
        // Apply ARB User Fine-Tuning Stiffness Modifier
        arbFront *= arbStiffnessMod;
        arbRear *= arbStiffnessMod;

        // Checking for Min-Max values
        arbBaseFront = Math.max(Math.min(arbBaseFront, maxArb), minArb);
        arbBaseRear = Math.max(Math.min(arbBaseRear, maxArb), minArb);

        // ------------------------
        // Determine Rebound & Bump
        // ------------------------

        // Setting Front Bump and Rebound Base values
        let bumpBase = 3.5 * bumpStiffnessMod;
        if (gameVersion == 'fh3') bumpBase = (bumpBase * 1.2) + 2;

        weightCalc = weight;
        while (weightCalc > 2750) {
            bumpBase -= 0.01;
            weightCalc -= 150;
        }
        while (weightCalc < 2500) {
            bumpBase += 0.01;
            weightCalc += 150;
        }

        // Calculating Bump and Rebound
        let bumpFront = bumpBase;
        let bumpRear = bumpBase;
        let reboundFront = bumpFront * reboundStiffnessMod;
        let reboundRear = bumpRear * reboundStiffnessMod * 0.86;

        if (driveType == 'awd') {
            bumpRear += 0.1;
            reboundFront += 0.75;
        } else if (driveType == 'fwd') {
            bumpRear += 0.2;
            reboundFront += 1.5;
        }

        if (engineLayout == 'mid') {
            bumpRear += 0.13;
            reboundRear += 0.22;
        } else if (engineLayout == 'rear') {
            bumpRear += 0.26;
            reboundRear += 0.44;
        }

        bumpFront *= bumpStiffnessMod;
        bumpRear *= bumpStiffnessMod;
        reboundFront *= reboundStiffnessMod;
        reboundRear *= reboundStiffnessMod;

        let bumpFront2 = 0;
        let bumpRear2 = 0;
        let reboundFront2 = 0;
        let reboundRear2 = 0;

        if (isOffroad) {
            if (gameVersion == 'fh3') {
                bumpFront = 2.5;
                bumpRear = 2.4;
                reboundFront = 8.5;
                reboundRear = 7.8;
                bumpFront2 *= 2;
                bumpRear2 *= 2;
                reboundFront2 *= 2;
                reboundRear2 *= 2;
            } else {
                bumpFront = 2.5;
                bumpRear = 2.4;
                reboundFront = 11.5;
                reboundRear = 10.5;
            }
        }

        // ----------
        // Dynamic Alignment Calculations
        // ----------
        
        // Determine Camber
        // RWD is the default for settings
        let camberFront = 2 + camberMod;
        let camberRear = 1.5 + camberMod;
        if (driveType == 'awd') {
            camberRear = 1.7 + camberMod;
        } else if (driveType == 'fwd') {
            camberFront = 1.6 + camberMod;
            camberRear = 1.6 + camberMod;
        }

        let tireModWFront = 0;

        if (tireCompound == 'sport') tireModWFront += 0.1;
        else if (tireCompound == 'race') tireModWFront += 0.2;
        else if (tireCompound == 'drag') tireModWFront -= 0.4;
        else if (tireCompound == 'rally') tireModWFront -= 0.1;
        else if (tireCompound == 'offroad') tireModWFront -= 0.2;

        let tireModWRear = tireModWFront;

        // Adjust for Weight and Weight Perc
        weightPercentageCalc = weightPercentageFront;
        while (weightPercentageCalc > 52) {
            tireModWFront -= 0.1;
            tireModWRear += 0.1;
            weightPercentageCalc -= 5;
        }
        while (weightPercentageCalc < 47) {
            tireModWFront += 0.1;
            tireModWRear -= 0.1;
            weightPercentageCalc += 5;
        }

        weightCalc = weight;
        while (weightCalc > 2000) {
            tireModWFront -= 0.1;
            tireModWRear -= 0.1;
            weightCalc -= 500;
        }

        // Adjust for Tire Tread Width and Sidewall Profile
        let tireWidthCalcFront = frontTire.width;
        while (tireWidthCalcFront > 280) {
            tireModWFront -= 0.1;
            tireWidthCalcFront -= 20;
        }

        let tireWidthCalcRear = rearTire.width;
        while (tireWidthCalcRear > 300) {
            tireModWRear -= 0.1;
            tireWidthCalcRear -= 20;
        }

        // Applying Front and Read Camber Modifiers
        camberFront += tireModWFront;
        camberRear += tireModWRear;

        camberFront = Math.max(0 - camberFront, 0);
        camberRear = Math.max(0 - camberRear, 0);

        // ----------
        // Determin Toe & Caster
        // ----------
        let caster = 5 + casterMod;
        let toeFront = 0;
        let toeRear = 0;

        if (driveType == 'rwd') {
            if (torque >= 600 || power >= 750) toeRear -= 0.1;
        } else if (driveType == 'awd') {
            caster -= 0.2;
            if (torque >= 600 || power >= 750) toeRear -= 0.1;
        } else if(driveType == 'fwd') {
            caster += 1.2;
        }

        if (engineLayout == 'mid') caster -= 0.2;
        else if (engineLayout == 'rear') caster -= 0.4;

        weightPercentageCalc = weightPercentageFront;
        while (weightPercentageCalc > 51) {
            caster += 0.1;
            weightPercentageCalc -= 2;
        }
        while (weightPercentageCalc < 49) {
            caster -= 0.1;
            weightPercentageCalc += 2;
        }

        if (isOffroad) {
            if (driveType == 'rwd') caster -= 1;
            else if (driveType == 'awd') caster -= 1.5;
            else if (driveType == 'fwd') caster -= 2;
        }

        let steeringAngle = "n/a";

        if (caster > 7) toeFront = 7;

        // ----------
        // Determin PSI/BAR
        // Calculated in PSI first and then converted if needed
        // ----------
        // REAR
        let tirePressureFront = 30;
        let tirePressureRear = 30;
        if (tireCompound == 'offroad') tirePressureRear = 25;
        else if (tireCompound == 'rally') tirePressureRear = 26;
        else if (tireCompound == 'race') tirePressureRear = 28;
        else if (tireCompound == 'drag') tirePressureRear = 28;
        else if (tireCompound == 'sport') tirePressureRear = 29.5;
        else if (tireCompound == 'street') tirePressureRear = 30.5;
        else if (tireCompound == 'stock') tirePressureRear = 31;
        // FRONT
        if (driveType == 'rwd') {
            if (tuningType == 'drag') tirePressureFront = 35;
            else tirePressureFront = tirePressureRear + 0.5;
        } else {
            tirePressureFront = tirePressureRear;
        }

        if (tuningType == 'drift') tirePressureRear = tirePressureFront - 5.5;

        if (isMetric) {
            tirePressureFront *= toMetricConv.pressure;
            tirePressureRear *= toMetricConv.pressure;
        }

        // ----------
        // Determin Brake Settings
        // ----------
        let brakeForce = 140;
        if (tireCompound == 'race') brakeForce = 140;
        else if (tireCompound == 'drag') brakeForce = 150;
        else if (tireCompound == 'rally') brakeForce = 135;
        else if (tireCompound == 'offroad') brakeForce = 135;
        else if (tireCompound == 'sport') brakeForce = 135;
        else if (tireCompound == 'street') brakeForce = 130;
        else if (tireCompound == 'stock') brakeForce = 130;

        let brakeBalance = 50;
        if (weightPercentageFront > 64) brakeBalance += 1;
        if (weightPercentageFront > 58) brakeBalance += 1;
        if (weightPercentageFront > 53) brakeBalance += 1;
        if (weightPercentageFront > 51) brakeBalance += 1;
        if (weightPercentageFront > 49 || tireWidthDiff >= 20) brakeBalance -= 1;
        if (weightPercentageFront > 46 || tireWidthDiff >= 50) brakeBalance -= 1;
        if (weightPercentageFront > 43 || tireWidthDiff >= 80) brakeBalance -= 1;
        if (weightPercentageFront > 40 || tireWidthDiff >= 120) brakeBalance -= 1;
        if (isOffroad) brakeBalance -= 1;

        brakeBalance = Math.min(brakeBalance, 54);

        // ----------
        // Determine Differential Settings
        // ----------

    }
}