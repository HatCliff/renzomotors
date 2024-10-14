const evaluarstrenght = (input)=>{
    let fitness = 0;
    if (input.match(/a-z/)) {
        console.log("MATCH");
        fitness += 1;
    }
    if (input.match(/A-Z/)) {
        console.log("MATCH");
        fitness += 1;
    }
    if (input.match(/0-9/)) {
        console.log("MATCH");
        fitness += 1;
    }
    if (input.match(/[^a-zA-Z0-9]/)) {
        console.log("MATCH");
        fitness += 1;
    }
    switch (fitness) {
        case 0:
            return "Nula";
            break;
        case 1:
            return "Baja";
            break;
        case 2:
            return "Media";
            break;    
        case 3: 
            return "Alta";
            break;
        case 4:
            return "Muy Alta";
            break;
        default:
            return "Nula";
            break;
    }
}


export default evaluarstrenght;