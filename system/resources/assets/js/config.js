export const adminUrl = location.href.split(/[?#]/)[0].replace(/\/$/, '');
export const apiUrl   = `${adminUrl}/api`;
export const baseUrl  = adminUrl.replace(/\/admin$/, '');