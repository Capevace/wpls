function getNested(theObject, path, separator = '.') {
    try {    
        return path
            .replace('[', separator).replace(']','')
            .split(separator)
            .reduce((obj, property) => obj[property], theObject); 
    } catch (err) {
        return undefined;
    }   
}

export default getNested;