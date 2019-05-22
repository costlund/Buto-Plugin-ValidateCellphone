# Buto-Plugin-ValidateCellphone

Form validator to validate cellphone (swedish).

Chell phone number must be in format 07xxxxxxxx.


```
items:
  phone:
    type: varchar
    label: Phone
    mandatory: true
    validator:
      -
        plugin: validate/cellphone
        method: validate_cellphone
```

