    function formatDate(dateString) {
// Create a new Date object from the dateString
    var date = new Date(dateString);
    // Get day, month, and year
    var day = date.getDate();
    var month = date.getMonth() + 1; // January is 0!
    var year = date.getFullYear();
    // Return the formatted date as string (DD/MM/YYYY)
    return `${day < 10 ? '0' + day : day}/${month < 10 ? '0' + month : month}/${year}`;
}