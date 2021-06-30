# Buto-Plugin-ValidateCellphone
Form validator to validate cellphone and/or country code.
Cellphone must have only numbers and ten digits.
Country code muste have only numbers and between 10 and 999.
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
  country:
    type: varchar
    label: Country code
    mandatory: true
    validator:
      -
        plugin: validate/cellphone
        method: validate_country_code
```

## Validate cellphone
Optional param country_code_param to validate length of number depending on country code.
```
plugin: validate/cellphone
method: validate_cellphone
data:
  country_code_param: country
```
