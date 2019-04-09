
# coding: utf-8

# # Matrix

# https://repl.it/@lionpowder/ConsciousMiniatureCookie

# In[51]:


from random import choice
from random import randint


class Adjacency_Matrix(object):
    def __init__(self, n, g_type):
        if g_type == 'S':
            self.matrix = self.__sparse_generator(n)
            self.__weight(n)
        elif g_type == 'C':
            self.matrix = self.__complete_generator(n)
            self.__weight(n)
        
    def __sparse_generator(self, n):
        matrix = [[0 for i in range(n)] for i in range(n)]
        exist = set()
        row = list(range(1, n)) 
        col = list(range(n))
        i = choice(row)
        j = choice(list(range(i)))
        matrix[i][j] = 1
        matrix[j][i] = 1
        exist.add(i)
        exist.add(j)
        while len(exist) < n:
            i = choice(list(exist))
            j = choice(list(set(col)-exist))
            matrix[i][j] = 1
            matrix[j][i] = 1
            exist.add(j)
        return matrix
    
    def __complete_generator(self, n):
        matrix = [[1 for i in range(n)] for i in range(n)]
        for i in range(n):
            matrix[i][i] = 0
        return matrix
        
    def __weight(self, n):
        for i in range(n):
            for j in range(i+1, n):
                if self.matrix[i][j] == 1:
                    temp = randint(1, n)
                    self.matrix[i][j] = temp
                    self.matrix[j][i] = temp


# In[1359]:


class Shortest_Path_Matrix(object):
    def __init__(self, matrix):
        self.matrix = [i[:] for i in matrix]
        
    def find(self, i, j, T):
        if T == 'd':
            return self.res[(i, j)]
        if T == 'f':
            return self.res2[(i, j)]
        
    def dijkstra(self):
        self.res = {}
        n = len(self.matrix[0])
        for i in range(n):
            opt_path = {}
            opt_path[i] = [str(i), 0]
            rest = {j:[str(i) + '->' + str(j), self.matrix[i][j]] for j in set(range(n)) - {i}}
            while len(rest) > 0:
                
                not_zero = [i for i in rest.items() if i[1][1] != 0]
                shortest = min(not_zero, key=lambda x:x[1][1])
                opt_path[shortest[0]] = shortest[1]
                del rest[shortest[0]]
                for j in rest:
                    if (rest[j][1] != 0 and self.matrix[shortest[0]][j] != 0 and rest[j][1] > shortest[1][1] + self.matrix[shortest[0]][j]) or (rest[j][1] == 0 and self.matrix[shortest[0]][j] != 0):
                        rest[j] = [shortest[1][0] + '->' + str(j), shortest[1][1] + self.matrix[shortest[0]][j]]
            for j in opt_path:
                self.res[(i, j)] = opt_path[j]
        print('Done')
        
    def floyd(self):
        self.res2 = {}
        n = len(self.matrix[0])
        state = [i[:] for i in self.matrix]
        temp = [i[:] for i in self.matrix]
        path = {(i, j):str(i) + '->' + str(j) for i in range(n) for j in range(n)}
        for k in range(n):
            for i in set(range(n)) - {k}:
                for j in set(range(n)) - {k, i}:
                    if (state[i][k] != 0 and state[k][j] != 0) and (temp[i][j] == 0 or (temp[i][j] != 0 and state[i][k] + state[k][j] < temp[i][j])):
                        temp[i][j] = state[i][k] + state[k][j]
                        path[(i, j)] = path[(i, k)][:-1] + path[(k, j)]
            state = [i[:] for i in temp]
        for i in range(n):
            for j in range(n):
                self.res2[(i, j)] = [path[(i,j)], state[i][j]]


# In[1376]:


t1_m = [[0,0,0,29,0,0,0,0], [0,0,0,0,0,11,11,0], [0,0,0,12,0,5,5,0],
      [29,0,12,0,5,0,13,0],[0,0,0,5,0,0,7,11],[0,11,5,0,0,0,0,17],
     [0,11,5,13,7,0,0,0],[0,0,0,0,11,17,0,0]]
test = Shortest_Path_Matrix(t1_m)
test.floyd()
test.dijkstra()
print('The result of floyd algorithm in matrix structure is:', test.find(0,7,'f'))
print('The result of dijkstra algorithm in matrix structure is:', test.find(0,7,'d'))
print('The result of floyd algorithm in matrix structure is:', test.find(6,7,'f'))
print('The result of dijkstra algorithm in matrix structure is:', test.find(6,7,'d'))


# In[1378]:


t2_m = [[0,11,14,0,8,0,29,28,0,0,14,0],[11,0,12,0,6,0,0,0,0,0,0,0],[14,12,0,18,13,13,0,0,25,0,0,16],
       [0,0,18,0,0,0,27,17,9,25,0,0],[8,6,13,0,0,0,0,0,0,0,0,22],[0,0,13,0,0,0,0,15,5,0,0,0],
       [29,0,0,27,0,0,0,0,0,0,0,0],[28,0,0,17,0,15,0,0,5,9,0,0],[0,0,25,9,0,5,0,5,0,0,25,0],
       [0,0,0,25,0,0,0,9,0,0,0,0],[14,0,0,0,0,0,0,0,25,0,0,0],[0,0,16,0,22,0,0,0,0,0,0,0]]
test = Shortest_Path_Matrix(t2_m)
test.floyd()
test.dijkstra()
print('The result of floyd algorithm in matrix structure is:', test.find(1,7,'f'))
print('The result of dijkstra algorithm in matrix structure is:', test.find(1,7,'d'))
print('The result of floyd algorithm in matrix structure is:', test.find(11,9,'f'))
print('The result of dijkstra algorithm in matrix structure is:', test.find(11,9,'d'))


# In[1093]:


a = Adjacency_Matrix(5, 'S')
b = Shortest_Path(a.matrix)

b.floyd()
b.dijkstra()
# b.res


# # ———————————Array——————————

# https://repl.it/@lionpowder/FuchsiaExcitableOctagon

# In[52]:


class Adjacency_Array(object):
    def __init__(self, n, g_type):
        if g_type == 'S':
            self.array = self.__sparse_generator(n)
            self.__weight(n)
        elif g_type == 'C':
            self.array = self.__complete_generator(n)
            self.__weight(n)
        
    def __sparse_generator(self, n):
        self.matrix = [[0 for i in range(n)] for i in range(n)]
        array = [0 for i in range(int(n * (n - 1) / 2))]
        exist = set()
        row = list(range(1, n)) 
        col = list(range(n))
        i = choice(row)
        j = choice(list(range(i)))
        if i < j:
            i, j = j, i
        array[int((i - 1) * i / 2 + j)] = 1
        exist.add(i)
        exist.add(j)
        while len(exist) < n:
            i = choice(list(exist))
            j = choice(list(set(col)-exist))
            exist.add(j)
            if i < j:
                i, j = j, i
            array[int((i - 1) * i / 2 + j)] = 1
        return array
    
    def __complete_generator(self, n):
        array = [1 for i in range(int(n * (n - 1) / 2))]
        return array
        
    def __weight(self, n):
        for i in range(int(n * (n - 1) / 2)):
            if self.array[i] == 1:
                self.array[i] = randint(1, n)


# In[1363]:


class Shortest_Path_Array(object):
    def __init__(self, array):
        self.array = array[:]
        
    def find(self, i, j, T):
        if T == 'd':
            return self.res[(i, j)]
        if T == 'f':
            return self.res2[(i, j)]
        
    def dijkstra(self, n):
        self.res = {}
        for i in range(n):
            opt_path = {}
            opt_path[i] = [str(i), 0]
            rest = {j:[str(i) + '->' + str(j), self.array[int((max(i,j) - 1) * max(i,j) / 2 + min(i,j))]] for j in set(range(n)) - {i}}
            while len(rest) > 0:
                not_zero = [i for i in rest.items() if i[1][1] != 0]
                shortest = min(not_zero, key=lambda x:x[1][1])
                opt_path[shortest[0]] = shortest[1]
                del rest[shortest[0]]
                for j in rest:
                    a = max(shortest[0], j)
                    b = min(shortest[0], j)
                    if (rest[j][1] != 0 and self.array[int((a - 1) * a / 2 + b)] != 0 and rest[j][1] > shortest[1][1] + self.array[int((a - 1) * a / 2 + b)]) or (rest[j][1] == 0 and self.array[int((a - 1) * a / 2 + b)] != 0):
                        rest[j] = [shortest[1][0] + '->' + str(j), shortest[1][1] + self.array[int((a - 1) * a / 2 + b)]]
            for j in opt_path:
                self.res[(i, j)] = opt_path[j]
        print('Done')
        
    def floyd(self, n):
        self.res2 = {}
        state = self.array[:]
        temp = self.array[:]
        self.path = {(i, j):str(i) + '->' + str(j) for i in range(n) for j in range(n) if i > j}
        for k in range(n):
            for i in set(range(1, n)) - {k}:
                for j in set(range(i)) - {k}:
                    a = max(i, k)
                    b = min(i, k)
                    c = max(k, j)
                    d = min(k, j)
                    if (state[int((a-1)*a/2+b)] != 0 and state[int((c-1)*c/2+d)] != 0) and (temp[int((i-1)*i/2+j)] == 0 or (temp[int((i-1)*i/2+j)] != 0 and state[int((a-1)*a/2+b)] + state[int((c-1)*c/2+d)] < temp[int((i-1)*i/2+j)])):

                        temp[int((i-1)*i/2+j)] = state[int((a-1)*a/2+b)] + state[int((c-1)*c/2+d)]# update the state matrix

                        if a == k:
                            s1 = '->'.join(self.path[(a, b)].split('->')[::-1])
                        else:
                            s1 = self.path[(a, b)]
                        if c == j:
                            s2 = '->'.join(self.path[(c, d)].split('->')[::-1])
                        else:
                            s2 = self.path[(c, d)]
                        self.path[(i, j)] = s1[:-1] + s2# update the path
            state = temp[:]
        for i in range(1, n):
            self.res2[(i, i)] = [str(i), 0]
            for j in range(i):
                self.res2[(i, j)] = [self.path[(i,j)], state[int((i-1)*i/2+j)]]
                self.res2[(j, i)] = ['->'.join(self.path[(i,j)].split('->')[::-1]), state[int((i-1)*i/2+j)]]
        self.res2[(0, 0)] = ['0', 0]


# In[1380]:


t1_m = [[0,0,0,29,0,0,0,0], [0,0,0,0,0,11,11,0], [0,0,0,12,0,5,5,0],
      [29,0,12,0,5,0,13,0],[0,0,0,5,0,0,7,11],[0,11,5,0,0,0,0,17],
     [0,11,5,13,7,0,0,0],[0,0,0,0,11,17,0,0]]

def transform(matrix):
    n = len(matrix)
    a = [0 for i in range(int(n * (n - 1) / 2))]
    l = Linked_List(0, 0)
    pointer = l
    for i in range(1, len(matrix)):
        for j in range(i):
            if matrix[i][j] != 0:
                a[int((i - 1) * i / 2 + j)] = matrix[i][j]
                pointer.next_node = Linked_List(int((i - 1) * i / 2 + j), matrix[i][j])
                pointer = pointer.next_node
    return a, l.next_node
t1_a, t1_l = transform(t1_m)
n = len(t1_m)
test = Shortest_Path_Array(t1_a)
test.floyd(n)
test.dijkstra(n)
print('The result of floyd algorithm in array structure is:', test.find(0,7,'f'))
print('The result of dijkstra algorithm in array structure is:', test.find(0,7,'d'))
print('The result of floyd algorithm in array structure is:', test.find(6,7,'f'))
print('The result of dijkstra algorithm in array structure is:', test.find(6,7,'d'))


# In[1381]:


t2_m = [[0,11,14,0,8,0,29,28,0,0,14,0],[11,0,12,0,6,0,0,0,0,0,0,0],[14,12,0,18,13,13,0,0,25,0,0,16],
       [0,0,18,0,0,0,27,17,9,25,0,0],[8,6,13,0,0,0,0,0,0,0,0,22],[0,0,13,0,0,0,0,15,5,0,0,0],
       [29,0,0,27,0,0,0,0,0,0,0,0],[28,0,0,17,0,15,0,0,5,9,0,0],[0,0,25,9,0,5,0,5,0,0,25,0],
       [0,0,0,25,0,0,0,9,0,0,0,0],[14,0,0,0,0,0,0,0,25,0,0,0],[0,0,16,0,22,0,0,0,0,0,0,0]]

def transform(matrix):
    n = len(matrix)
    a = [0 for i in range(int(n * (n - 1) / 2))]
    l = Linked_List(0, 0)
    pointer = l
    for i in range(1, len(matrix)):
        for j in range(i):
            if matrix[i][j] != 0:
                a[int((i - 1) * i / 2 + j)] = matrix[i][j]
                pointer.next_node = Linked_List(int((i - 1) * i / 2 + j), matrix[i][j])
                pointer = pointer.next_node
    return a, l.next_node
t2_a, t2_l = transform(t2_m)
n = len(t2_m)
test = Shortest_Path_Array(t2_a)
test.floyd(n)
test.dijkstra(n)
print('The result of floyd algorithm in array structure is:', test.find(1,7,'f'))
print('The result of dijkstra algorithm in array structure is:', test.find(1,7,'d'))
print('The result of floyd algorithm in array structure is:', test.find(11,9,'f'))
print('The result of dijkstra algorithm in array structure is:', test.find(11,9,'d'))


# # Linked list

# https://repl.it/@lionpowder/LiveEarnestTrapezoids

# In[22]:


class Linked_List(object):
    def __init__(self, name, val):
        self.name = name
        self.val = val
        self.next_node = None
    def find(self, name):
        pointer = self
        while pointer != None:
            if pointer.name == name:
                return pointer.val
            pointer = pointer.next_node
        return 0
    def set_val(self, name):
        pointer = self
        while pointer != None:
            if pointer.name == name:
                return pointer
            pointer = pointer.next_node
        return None
    def copy(self):
        pointer = self
        temp = Linked_List(0,0)
        cor = temp
        while pointer != None:
            cor.next_node = Linked_List(pointer.name,pointer.val)
            pointer = pointer.next_node
            cor = cor.next_node
        return temp.next_node

class Adjacency_List(object):
    def __init__(self, n, g_type):
        if g_type == 'S':
            self.linked_list = self.__sparse_generator(n)
            self.__weight(n)
        elif g_type == 'C':
            self.linked_list = self.__complete_generator(n)
            self.__weight(n)
        
    def __sparse_generator(self, n):
        self.matrix = [[0 for i in range(n)] for i in range(n)]
        array = [0 for i in range(int(n * (n - 1) / 2))]
            
        exist = set()
        row = list(range(1, n)) 
        col = list(range(n))
        i = choice(row)
        j = choice(list(range(i)))
        if i < j:
            i, j = j, i
        array[int((i - 1) * i / 2 + j)] = 1
        linked_list = Linked_List(int((i - 1) * i / 2 + j), 1)
        pointer = linked_list
        exist.add(i)
        exist.add(j)
        while len(exist) < n:
            i = choice(list(exist))
            j = choice(list(set(col)-exist))
            exist.add(j)
            if i < j:
                i, j = j, i
            array[int((i - 1) * i / 2 + j)] = 1
            pointer.next_node = Linked_List(int((i - 1) * i / 2 + j), 1)
            pointer = pointer.next_node
        return linked_list
    
    def __complete_generator(self, n):
        linked_list = Linked_List(0, 1)
        pointer = linked_list
        for i in range(1, int(n * (n - 1) / 2)):
            pointer.next_node = Linked_List(i, 1)
            pointer = pointer.next_node
        return linked_list
        
    def __weight(self, n):
        pointer = self.linked_list
        while pointer != None:
            pointer.val = randint(1, n)
            pointer = pointer.next_node


# In[23]:



a = Adjacency_List(4, "S")
x = a.linked_list
linked_list = a.linked_list
b = x.copy()
x.val = 500
while x != None:
    print(x.name,x.val)
    x = x.next_node
print('\n')
# b = Shortest_Path_List(linked_list)
# b.floyd(4)
# b.res2
while b != None:
    print(b.name,b.val)
    b = b.next_node


# In[24]:


class Shortest_Path_List(object):
    def __init__(self, linked_list):
        self.linked_list = linked_list.copy()
        
    def find(self, i, j, T):
        if T == 'd':
            return self.res[(i, j)]
        if T == 'f':
            return self.res2[(i, j)]
        
    def dijkstra(self, n):
        self.res = {}
        for i in range(n):
            opt_path = {}
            opt_path[i] = [str(i), 0]
            rest = {j:[str(i) + '->' + str(j), self.linked_list.find(int((max(i,j) - 1) * max(i,j) / 2 + min(i,j)))] for j in set(range(n)) - {i}}
            while len(rest) > 0:
                not_zero = [i for i in rest.items() if i[1][1] != 0]
                shortest = min(not_zero, key=lambda x:x[1][1])
                opt_path[shortest[0]] = shortest[1]
                del rest[shortest[0]]
                for j in rest:
                    a = max(shortest[0], j)
                    b = min(shortest[0], j)
                    if (rest[j][1] != 0 and self.linked_list.find(int((a - 1) * a / 2 + b)) != 0 and rest[j][1] > shortest[1][1] + self.linked_list.find(int((a - 1) * a / 2 + b))) or (rest[j][1] == 0 and self.linked_list.find(int((a - 1) * a / 2 + b)) != 0):
                        rest[j] = [shortest[1][0] + '->' + str(j), shortest[1][1] + self.linked_list.find(int((a - 1) * a / 2 + b))]
            for j in opt_path:
                self.res[(i, j)] = opt_path[j]
        print('Done')
        
    def floyd(self, n):
        self.res2 = {}
        state = self.linked_list.copy()
        temp = self.linked_list.copy()
        path = {(i, j):str(i) + '->' + str(j) for i in range(n) for j in range(n) if i > j}
        for k in range(n):
            for i in set(range(1, n)) - {k}:
                for j in set(range(i)) - {k}:
                    a = max(i, k)
                    b = min(i, k)
                    c = max(k, j)
                    d = min(k, j)
                    if (state.find(int((a-1)*a/2+b)) != 0 and state.find(int((c-1)*c/2+d)) != 0) and (temp.find(int((i-1)*i/2+j)) == 0 or (temp.find(int((i-1)*i/2+j)) != 0 and state.find(int((a-1)*a/2+b)) + state.find(int((c-1)*c/2+d)) < temp.find(int((i-1)*i/2+j)))):
                        if temp.set_val(int((i-1)*i/2+j)) == None:
                            new = Linked_List(int((i-1)*i/2+j), state.find(int((a-1)*a/2+b)) + state.find(int((c-1)*c/2+d)))
                            new.next_node = temp
                            temp = new
                        else:
                            temp.set_val(int((i-1)*i/2+j)).val = state.find(int((a-1)*a/2+b)) + state.find(int((c-1)*c/2+d))

                        if a == k:
                            s1 = '->'.join(path[(a, b)].split('->')[::-1])
                        else:
                            s1 = path[(a, b)]
                        if c == j:
                            s2 = '->'.join(path[(c, d)].split('->')[::-1])
                        else:
                            s2 = path[(c, d)]
                        path[(i, j)] = s1[:-1] + s2# update the path
            state = temp.copy()
        for i in range(1, n):
            self.res2[(i, i)] = [str(i), 0]
            for j in range(i):
                self.res2[(i, j)] = [path[(i,j)], state.find(int((i-1)*i/2+j))]
                self.res2[(j, i)] = ['->'.join(path[(i,j)].split('->')[::-1]), state.find(int((i-1)*i/2+j))]
        self.res2[(0, 0)] = ['0', 0]


# In[25]:


t1_m = [[0,0,0,29,0,0,0,0], [0,0,0,0,0,11,11,0], [0,0,0,12,0,5,5,0],
      [29,0,12,0,5,0,13,0],[0,0,0,5,0,0,7,11],[0,11,5,0,0,0,0,17],
     [0,11,5,13,7,0,0,0],[0,0,0,0,11,17,0,0]]

def transform(matrix):
    n = len(matrix)
    a = [0 for i in range(int(n * (n - 1) / 2))]
    l = Linked_List(0, 0)
    pointer = l
    for i in range(1, len(matrix)):
        for j in range(i):
            if matrix[i][j] != 0:
                a[int((i - 1) * i / 2 + j)] = matrix[i][j]
                pointer.next_node = Linked_List(int((i - 1) * i / 2 + j), matrix[i][j])
                pointer = pointer.next_node
    return a, l.next_node
t1_a, t1_l = transform(t1_m)

n = len(t1_m)
test = Shortest_Path_List(t1_l)
test.floyd(n)
test.dijkstra(n)
print('The result of floyd algorithm in linked list structure is:', test.find(0,7,'f'))
print('The result of dijkstra algorithm in linked list structure is:', test.find(0,7,'d'))
print('The result of floyd algorithm in linked list structure is:', test.find(6,7,'f'))
print('The result of dijkstra algorithm in linked list structure is:', test.find(6,7,'d'))


# In[1384]:


t2_m = [[0,11,14,0,8,0,29,28,0,0,14,0],[11,0,12,0,6,0,0,0,0,0,0,0],[14,12,0,18,13,13,0,0,25,0,0,16],
       [0,0,18,0,0,0,27,17,9,25,0,0],[8,6,13,0,0,0,0,0,0,0,0,22],[0,0,13,0,0,0,0,15,5,0,0,0],
       [29,0,0,27,0,0,0,0,0,0,0,0],[28,0,0,17,0,15,0,0,5,9,0,0],[0,0,25,9,0,5,0,5,0,0,25,0],
       [0,0,0,25,0,0,0,9,0,0,0,0],[14,0,0,0,0,0,0,0,25,0,0,0],[0,0,16,0,22,0,0,0,0,0,0,0]]

def transform(matrix):
    n = len(matrix)
    a = [0 for i in range(int(n * (n - 1) / 2))]
    l = Linked_List(0, 0)
    pointer = l
    for i in range(1, len(matrix)):
        for j in range(i):
            if matrix[i][j] != 0:
                a[int((i - 1) * i / 2 + j)] = matrix[i][j]
                pointer.next_node = Linked_List(int((i - 1) * i / 2 + j), matrix[i][j])
                pointer = pointer.next_node
    return a, l.next_node
t2_a, t2_l = transform(t2_m)

n = len(t2_m)
test = Shortest_Path_List(t2_l)
test.floyd(n)
test.dijkstra(n)
print('The result of floyd algorithm in linked list structure is:', test.find(1,7,'f'))
print('The result of dijkstra algorithm in linked list structure is:', test.find(1,7,'d'))
print('The result of floyd algorithm in linked list structure is:', test.find(11,9,'f'))
print('The result of dijkstra algorithm in linked list structure is:', test.find(11,9,'d'))


# In[89]:


get_ipython().magic('matplotlib inline')
import matplotlib.pyplot as plt
import time
from random import choice
from random import randint
import psutil
import sys
# import sys
# sys.setrecursionlimit(10000)


# In[74]:


x = [10,30,50,100,200,300,400,1000]
times = []
info = psutil.virtual_memory() 
for i in x:
#     start = time.clock()
    data = Adjacency_List(i,'S')
#     test = Shortest_Path_List(data.linked_list)
#     test.dijkstra(i)
#     end = time.clock()
#     times.append([str(i),"nodes:",psutil.Process(os.getpid()).memory_info().rss])
    print(str(i),"nodes:",psutil.Process(os.getpid()).memory_info().rss)

# print u'内存使用：',psutil.Process(os.getpid()).memory_info().rss 
# print u'总内存：',info.total 
# print u'内存占比：',info.percent
# plt.plot(x, times)#m,s,f
# print(times)


# In[110]:


data = Adjacency_Array(1000,'S')
print("1000 nodes:",sys.getsizeof(data.array))

