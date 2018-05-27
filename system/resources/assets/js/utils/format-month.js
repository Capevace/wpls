export default function formatMonth(month) {
    let monthNumber = month + 1;
    return monthNumber < 10 ? '0' + String(monthNumber) : String(monthNumber);
}
