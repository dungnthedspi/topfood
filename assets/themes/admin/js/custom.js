function goBack() {
    window.history.back();
}
function redirectTo(href) {
    window.location.href = href;
}
function confirmDelete(e, href) {
    e.preventDefault();
    if (confirm("Bạn chắc chắn muốn xóa?")) {
        console.log(e);
        return redirectTo(href);
    }
    return false;
}