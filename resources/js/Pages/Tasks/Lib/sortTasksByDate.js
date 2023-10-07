import dayjs from 'dayjs';
import utc from 'dayjs/plugin/utc';
import timezone from 'dayjs/plugin/timezone';

dayjs.extend(utc);
dayjs.extend(timezone);

/**
 * Sorts tasks by date for output;
 * @param {Array} tasks        Tasks
 * @param {string} timezone    Server's timezone
 * @param {boolean} isArchive  Server's timezone
 * @returns                    Sorted tasks
 */
export const sortTasksByDate = (tasks, timezone, isArchive) => {
    const sorted = {};

    tasks.forEach(task => {
        let key = 'Anytime';

        if (task.notify_at) {
            const date = dayjs.tz(task.notify_at, timezone).tz(dayjs.tz.guess());

            if (!isArchive && date.isBefore(dayjs(), 'day')) {
                key = 'Overdue';

                task.time = date.format('MMM D [at] HH:mm');
            } else {
                key = date.format('MMM D[,] dddd');

                task.time = date.format('[at] HH:mm');
            }
        }

        if (sorted[key]) {
            sorted[key].push(task);
        } else {
            sorted[key] = [task];
        }
    });

    return Object.entries(sorted);
};
