export default function announcementTypeToModifierClass(type) {
    switch (type) {
        case 'info':
            return 'is-primary';
        case 'success':
            return 'is-success';
        case 'warning':
            return 'is-warning';
        case 'error':
            return 'is-danger';
        case 'default':
        default:
            return 'is-white';
    }
}