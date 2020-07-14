const byte = function(number: number | null): string {
    if (number === null) {
        return '';
    }

    const negative = number < 0;
    const units = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

    if (negative) {
        number = -number;
    }

    if (number < 1) {
        return (negative ? '-' : '') + number + ' B';
    }

    const exponent = Math.min(Math.floor(Math.log(number) / Math.log(1000)), units.length - 1);
    number = Number((number / Math.pow(1000, exponent)).toFixed(2)) * 1;
    const unit = units[exponent];

    return (negative ? '-' : '') + number + ' ' + unit;
};

const bytesPerSecond = function(number: number | null): string {
    const byte_string = byte(number);

    if (byte_string === '') {
        return '';
    }

    return byte_string + '/s';
};

const duration = function(number: number | null): string {
    if (number === null) {
        return '';
    }

    const hour = 60 * 60;
    const minute = 60;

    if (number < minute) {
        return `${number}s`;
    }

    if (number < hour) {
        const minutes = Math.floor(number / minute);
        const seconds = number % minutes;

        return `${minutes}m ${seconds}s`;
    }

    const hours = Math.floor(number / hour);
    const minutes = Math.floor((number % hour) / minute);

    return `${hours}h ${minutes}m`;
};

export {
    byte,
    bytesPerSecond,
    duration,
};