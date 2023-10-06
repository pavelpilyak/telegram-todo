import { formatDatePart } from './formatDatePart';

/**
 * Formats date to backend format.
 * @param {Date} date Date
 * @returns Formatted date
 */
export const formatDate = date => (
    [
        date.getFullYear(),
        formatDatePart(date.getMonth() + 1),
        formatDatePart(date.getDate()),
    ].join('-') +
    ' ' +
    [
        formatDatePart(date.getHours()),
        formatDatePart(date.getMinutes()),
    ].join(':')
);
