# Experience

One day I wondered why we don't code a CSV reading function by hand in PHP.  
So I coded a fgetcsv in php and here's the result

The aim wasn't to make something good, but to make something functional that was close enough to what real function does

I found a 3.5GB CSV on the Internet for testing purposes.

## test speed myfgetcsv

First, test with my function

```
php testSpeedA.php 100 60
```

```
chunk: 100
time_limit: 60
time: 60.048249006271
count: 53400
889 i/s
```

Okay 889 item per second

## test speed fgetcsv

To be compared, execute fgetcsv

```
php testSpeedB.php 100 60
```

```
chunk: 100
time_limit: 60
time: 36.080882072449
count: 4555800
126266 i/s
```

Oh that very fast

## Conclusion

Use fgetcsv
