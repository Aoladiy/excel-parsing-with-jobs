@vite(['resources/js/app.js'])

{{-- <pre>{{json_encode($data, JSON_PRETTY_PRINT)}}</pre> --}}

<ul id="main-list">
    @foreach($data as $date => $rows)
        <li>{{$date}}</li>
        <ul id="list-{{$date}}">
            @foreach($rows as $row)
                <li>{{$row->id}} - {{$row->name}}</li>
            @endforeach
        </ul>
    @endforeach
</ul>

<script>
    window.addEventListener('newRowAdded', function(event) {
        const { id, name, date } = event.detail;
        const newItem = document.createElement('li');
        newItem.textContent = `${id} - ${name}`;

        const listId = `list-${date}`;
        let rowsList = document.getElementById(listId);

        if (!rowsList) {
            const mainList = document.getElementById('main-list');
            const newDateItem = document.createElement('li');
            newDateItem.textContent = date;
            mainList.appendChild(newDateItem);

            rowsList = document.createElement('ul');
            rowsList.id = listId;
            mainList.appendChild(rowsList);
        }

        // Проверяем, есть ли уже элемент с таким id в текущем списке
        const existingItems = rowsList.getElementsByTagName('li');
        let shouldAdd = true;
        for (let i = 0; i < existingItems.length; i++) {
            if (existingItems[i].textContent.startsWith(`${id} -`)) {
                shouldAdd = false;
                break;
            }
        }

        if (shouldAdd) {
            rowsList.prepend(newItem);
        } else {
            // console.log(`Элемент с id ${id} уже существует в списке ${listId}. Новая строка не добавлена.`);
        }
    });
</script>

