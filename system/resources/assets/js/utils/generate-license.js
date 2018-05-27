import randomstring from 'randomstring';

function generateLicense() {
    return randomstring.generate({
        length: 32,
        charset: 'alphanumeric'
    });
}

export default generateLicense;
