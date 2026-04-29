@list = [1, 2, 3, 4, 5];
@new_list = @list.map(fn(@n){ return @n * 2; });

print(@new_list);