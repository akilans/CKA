# JSON-PATH and YAML

### YAML
* YAML - dictionary
```
  name: akilan
  age: 32
  location: london
```
* YAML - List
```
- name: akilan
  age: 32
  location: london
- name: inba
  age: 1
  location: avr
```

### JSON PATH
* $.akilan.age - returns "Akilan's" age
* $.inba.age - returns "Inba's" age
* $.inba.age.places[1] - returns "Inba's" 2nd place
* $.akilan.marks[?(@ > 35)] - returns akilan's mark greater than 35
* $.*.name - returns [Akilan,Inba]

```
{
    akilan: {
        name: Akilan,
        age: 32,
        marks:[34,75, 65, 20]
        places: [
            "avr",
            "bangalore",
            "london"
        ]
    },
    inba: {
        name: Inba,
        age: 1,
        places:[
            "vaikai",
            "avr",
            "bangalore"
        ]
    }
}
```
* $.prizes[5].laureates[1]
* $.prizes[5].laureates[?(@.firstname == "Malala")]
* $.prizes[*].laureates[*].firstname - find the first names of all winners
* $.prizes.[?(@.year == "2014")].laureates[*].firstname -  find the first names of all winners of year 2014
* $[0] - first element in the list
* $[-1:] - last element in the ;ist
* $[0:3] - 1,2,3 - 
* $[0:5:2] - 0,2,4
* $[-1:0]  - All elements from last
* $[-3:] - last 3 elements
* $.[-5:] - last 5 elements
```
{
  "prizes": [
    {
      "year": "2018",
      "category": "physics",
      "overallMotivation": "\"for groundbreaking inventions in the field of laser physics\"",
      "laureates": [
        {
          "id": "960",
          "firstname": "Arthur",
          "surname": "Ashkin",
          "motivation": "\"for the optical tweezers and their application to biological systems\"",
          "share": "2"
        },
        {
          "id": "961",
          "firstname": "Gérard",
          "surname": "Mourou",
          "motivation": "\"for their method of generating high-intensity, ultra-short optical pulses\"",
          "share": "4"
        },
        {
          "id": "962",
          "firstname": "Donna",
          "surname": "Strickland",
          "motivation": "\"for their method of generating high-intensity, ultra-short optical pulses\"",
          "share": "4"
        }
      ]
    },
    {
      "year": "2018",
      "category": "chemistry",
      "laureates": [
        {
          "id": "963",
          "firstname": "Frances H.",
          "surname": "Arnold",
          "motivation": "\"for the directed evolution of enzymes\"",
          "share": "2"
        },
        {
          "id": "964",
          "firstname": "George P.",
          "surname": "Smith",
          "motivation": "\"for the phage display of peptides and antibodies\"",
          "share": "4"
        },
        {
          "id": "965",
          "firstname": "Sir Gregory P.",
          "surname": "Winter",
          "motivation": "\"for the phage display of peptides and antibodies\"",
          "share": "4"
        }
      ]
    },
    {
      "year": "2018",
      "category": "medicine",
      "laureates": [
        {
          "id": "958",
          "firstname": "James P.",
          "surname": "Allison",
          "motivation": "\"for their discovery of cancer therapy by inhibition of negative immune regulation\"",
          "share": "2"
        },
        {
          "id": "959",
          "firstname": "Tasuku",
          "surname": "Honjo",
          "motivation": "\"for their discovery of cancer therapy by inhibition of negative immune regulation\"",
          "share": "2"
        }
      ]
    },
    {
      "year": "2018",
      "category": "peace",
      "laureates": [
        {
          "id": "966",
          "firstname": "Denis",
          "surname": "Mukwege",
          "motivation": "\"for their efforts to end the use of sexual violence as a weapon of war and armed conflict\"",
          "share": "2"
        },
        {
          "id": "967",
          "firstname": "Nadia",
          "surname": "Murad",
          "motivation": "\"for their efforts to end the use of sexual violence as a weapon of war and armed conflict\"",
          "share": "2"
        }
      ]
    },
    {
      "year": "2018",
      "category": "economics",
      "laureates": [
        {
          "id": "968",
          "firstname": "William D.",
          "surname": "Nordhaus",
          "motivation": "\"for integrating climate change into long-run macroeconomic analysis\"",
          "share": "2"
        },
        {
          "id": "969",
          "firstname": "Paul M.",
          "surname": "Romer",
          "motivation": "\"for integrating technological innovations into long-run macroeconomic analysis\"",
          "share": "2"
        }
      ]
    },
    {
      "year": "2014",
      "category": "peace",
      "laureates": [
        {
          "id": "913",
          "firstname": "Kailash",
          "surname": "Satyarthi",
          "motivation": "\"for their struggle against the suppression of children and young people and for the right of all children to education\"",
          "share": "2"
        },
        {
          "id": "914",
          "firstname": "Malala",
          "surname": "Yousafzai",
          "motivation": "\"for their struggle against the suppression of children and young people and for the right of all children to education\"",
          "share": "2"
        }
      ]
    },
    {
      "year": "2017",
      "category": "physics",
      "laureates": [
        {
          "id": "941",
          "firstname": "Rainer",
          "surname": "Weiss",
          "motivation": "\"for decisive contributions to the LIGO detector and the observation of gravitational waves\"",
          "share": "2"
        },
        {
          "id": "942",
          "firstname": "Barry C.",
          "surname": "Barish",
          "motivation": "\"for decisive contributions to the LIGO detector and the observation of gravitational waves\"",
          "share": "4"
        },
        {
          "id": "943",
          "firstname": "Kip S.",
          "surname": "Thorne",
          "motivation": "\"for decisive contributions to the LIGO detector and the observation of gravitational waves\"",
          "share": "4"
        }
      ]
    },
    {
      "year": "2017",
      "category": "chemistry",
      "laureates": [
        {
          "id": "944",
          "firstname": "Jacques",
          "surname": "Dubochet",
          "motivation": "\"for developing cryo-electron microscopy for the high-resolution structure determination of biomolecules in solution\"",
          "share": "3"
        },
        {
          "id": "945",
          "firstname": "Joachim",
          "surname": "Frank",
          "motivation": "\"for developing cryo-electron microscopy for the high-resolution structure determination of biomolecules in solution\"",
          "share": "3"
        },
        {
          "id": "946",
          "firstname": "Richard",
          "surname": "Henderson",
          "motivation": "\"for developing cryo-electron microscopy for the high-resolution structure determination of biomolecules in solution\"",
          "share": "3"
        }
      ]
    },
    {
      "year": "2017",
      "category": "medicine",
      "laureates": [
        {
          "id": "938",
          "firstname": "Jeffrey C.",
          "surname": "Hall",
          "motivation": "\"for their discoveries of molecular mechanisms controlling the circadian rhythm\"",
          "share": "3"
        },
        {
          "id": "939",
          "firstname": "Michael",
          "surname": "Rosbash",
          "motivation": "\"for their discoveries of molecular mechanisms controlling the circadian rhythm\"",
          "share": "3"
        },
        {
          "id": "940",
          "firstname": "Michael W.",
          "surname": "Young",
          "motivation": "\"for their discoveries of molecular mechanisms controlling the circadian rhythm\"",
          "share": "3"
        }
      ]
    }
  ]
}
```

### Wild card
* $.*.wheels[*].model - extract models of all wheels of car and bus
```
{
  "car": {
    "color": "blue",
    "price": "$20,000",
    "wheels": [
      {
        "model": "KDJ39848T",
        "location": "front-right"
      },
      {
        "model": "MDJ39485DK",
        "location": "front-left"
      },
      {
        "model": "KCMDD3435K",
        "location": "rear-right"
      },
      {
        "model": "JJDH34234KK",
        "location": "rear-left"
      }
    ]
  },
  "bus": {
    "color": "white",
    "price": "$120,000",
    "wheels": [
      {
        "model": "BBBB39848T",
        "location": "front-right"
      },
      {
        "model": "BBBB9485DK",
        "location": "front-left"
      },
      {
        "model": "BBBB3435K",
        "location": "rear-right"
      },
      {
        "model": "BBBB4234KK",
        "location": "rear-left"
      }
    ]
  }
}
```
* $.employee.payslips[*].amount - Retreive all the amount's paid to the employee

```
{
  "employee": {
    "name": "john",
    "gender": "male",
    "age": 24,
    "address": {
      "city": "edison",
      "state": "new jersey",
      "country": "united states"
    },
    "payslips": [
      {
        "month": "june",
        "amount": 1400
      },
      {
        "month": "july",
        "amount": 2400
      },
      {
        "month": "august",
        "amount": 3400
      }
    ]
  }
}
```

### kubectl json path
* kubectl get node -o json
* kubectl get node -o=jsonpath='{.items[*].metadata.name}{"\n"}{.items[*].status.capacity.cpu}'
* kubectl get node -o=jsonpath='{range .items[*]}{.metadata.name}{"\t"}{.status.capacity.cpu}{"\n"}'
* kubectl get nodes -o=custom-columns=NODE:.metadata.name,CPU:.status.capacity.cpu
* kubectl get nodes --sort-by=.metadata.name [No need to mention items here]
* kubectl get pv --sort-by=.spec.capacity.storage [No need to mention items here]
* kubectl config view --kubeconfig=my-kube-config -o=jsonpath='{.contexts[?(@.context.user=="aws-user")].name}'