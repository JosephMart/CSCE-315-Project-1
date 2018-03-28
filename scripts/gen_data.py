from datetime import datetime, timedelta
from random import randint

"""
INSERT INTO `PeopleCounts` (`id`, `time`, `entering`) VALUES
    (NULL, '2018-03-28 05:47:43', 'false');
"""

def make_row(d: datetime, entering: str):
    return f"(NULL, '{d.strftime('%Y-%m-%d %H:%M:%S')}', '{entering}')"

def main():
    now = datetime.now()
    current_date_index = now - timedelta(days=30*5)
    rows = []

    while now > current_date_index:
        entered = exited = randint(20, 30)

        for _ in range(entered):
            hour = randint(8, 20)
            minute = randint(0, 59)
            rand_date = current_date_index.replace(hour=hour, minute=minute)
            rows.append(make_row(rand_date, 'false'))
        
        for _ in range(exited):
            hour = randint(8, 20)
            minute = randint(0, 59)
            rand_date = current_date_index.replace(hour=hour, minute=minute)
            rows.append(make_row(rand_date, 'true'))

        current_date_index += timedelta(days=1)
    row_str = ',\n'.join(rows)
    query = f"INSERT INTO `PeopleCounts` (`id`, `time`, `entering`) VALUES\n{row_str};"
    print(query)


if __name__ == '__main__':
    main()