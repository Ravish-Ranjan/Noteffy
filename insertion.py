import time
class insertion:
    def __init__(self):
        pass
    def _insertionSort_(self,size,arr):
        count = 0
        for j in range(1,size):
            key = arr[j]
            i = j-1
            while i>=0 and arr[i]>key:
                count = count+1
                arr[i+1] = arr[i]
                i = i-1
            arr[i+1] = key
        print("\n\nNo. of comaprisions are : {}\n\n".format(count+1))
        return arr
if __name__ == '__main__':
    lst = eval(input("Enter an array : "))
    size = len(lst)
    then = time.time()
    obj = insertion()
    lst = obj._insertionSort_(size,lst)
    now = time.time()
    print(lst)
    print("\n\ntime taken = {0:.30f}".format(now-then))