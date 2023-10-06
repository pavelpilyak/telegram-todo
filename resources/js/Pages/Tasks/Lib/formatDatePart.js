/**
 * Formats date part from Date object.
 * @param {number} part  Month/Day/Hour/Minute
 * @returns              Part with leading zero if part is less than 10.
 */
export const formatDatePart = part => part.toString().padStart(2, '0');
