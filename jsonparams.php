<?php
    function searchParamsNormal($getParams, $currentpagevalue, $query, $fpartij, $fjaar)
    {
        if ($fpartij == "0" && $fjaar == "0")
        {
            $getParams['body'] = [
                'from' => $currentpagevalue*10,
                'size' => 10,
                'query' => [
                    'bool' => [
                        'should' => [
                            ['match' => [
                                'vraag' => $query
                            ]],
                            ['match' => [
                                'antwoord' => $query
                            ]],
                            ['match' => [
                                'indiener' => $query
                            ]]
                        ]
                    ]
                ],
                'aggs' => [
                    'aggspartij' => [
                        'terms' => [
                            'field' => 'partij',
                            'size' => 0
                        ]
                    ],
                    'aggsjaar' => [
                        'terms' => [
                            'field' => 'jaar',
                            'size' => 0,
                            'order' => [
                                '_term' => 'asc'
                            ]
                        ]
                    ]
                ]
            ];
        }
        elseif ($fpartij != "0" && $fjaar == "0")
        {
            $getParams['body'] = [
                'from' => $currentpagevalue*10,
                'size' => 10,
                'query' => [
                    'bool' => [
                        'should' => [
                            ['match' => [
                                'vraag' => $query
                            ]],
                            ['match' => [
                                'antwoord' => $query
                            ]],
                            ['match' => [
                                'indiener' => $query
                            ]]
                        ]
                    ]
                ],
                'aggs' => [
                    'aggspartij' => [
                        'terms' => [
                            'field' => 'partij',
                            'size' => 0
                        ]
                    ],
                    'aggsjaar' => [
                        'filter' => [
                            'term' => [
                                'partij' => $fpartij
                            ]
                        ],
                        'aggs' => [
                            'aggsjaar2' => [
                                 'terms' => [
                                     'field' => 'jaar',
                                     'size' => 0,
                                     'order' => [
                                         '_term' => 'asc'
                                     ]
                                 ]
                             ]
                         ]
                    ]
                ],
                'filter' => [
                    'term' => [
                        'partij' => $fpartij
                    ]
                ]
            ];
        }
        elseif ($fpartij == "0" && $fjaar != "0")
        {
            $getParams['body'] = [
                'from' => $currentpagevalue*10,
                'size' => 10,
                'query' => [
                    'bool' => [
                        'should' => [
                            ['match' => [
                                'vraag' => $query
                            ]],
                            ['match' => [
                                'antwoord' => $query
                            ]],
                            ['match' => [
                                'indiener' => $query
                            ]]
                        ]
                    ]
                ],
                'aggs' => [
                    'aggspartij' => [
                        'filter' => [
                            'term' => [
                                'jaar' => $fjaar
                            ]
                        ],
                        'aggs' => [
                            'aggspartij2' => [
                                 'terms' => [
                                     'field' => 'partij',
                                     'size' => 0
                                 ]
                             ]
                         ]
                    ],
                    'aggsjaar' => [
                        'terms' => [
                            'field' => 'jaar',
                            'size' => 0,
                            'order' => [
                                '_term' => 'asc'
                            ]
                        ]
                    ]
                ],
                'filter' => [
                    'term' => [
                        'jaar' => $fjaar
                    ]
                ]
            ];
        }
        elseif ($fpartij != "0" && $fjaar != "0")
        {
            $getParams['body'] = [
                'from' => $currentpagevalue*10,
                'size' => 10,
                'query' => [
                    'bool' => [
                        'should' => [
                            ['match' => [
                                'vraag' => $query
                            ]],
                            ['match' => [
                                'antwoord' => $query
                            ]],
                            ['match' => [
                                'indiener' => $query
                            ]]
                        ]
                    ]
                ],
                'aggs' => [
                    'aggspartij' => [
                        'filter' => [
                            'term' => [
                                'jaar' => $fjaar
                            ]
                        ],
                        'aggs' => [
                            'aggspartij2' => [
                                 'terms' => [
                                     'field' => 'partij',
                                     'size' => 0
                                 ]
                             ]
                         ]
                    ],
                    'aggsjaar' => [
                        'filter' => [
                            'term' => [
                                'partij' => $fpartij
                            ]
                        ],
                        'aggs' => [
                            'aggsjaar2' => [
                                 'terms' => [
                                     'field' => 'jaar',
                                     'size' => 0,
                                     'order' => [
                                         '_term' => 'asc'
                                     ]
                                 ]
                             ]
                         ]
                    ]
                ],
                'filter' => [
                    'and' => [
                        ['term' => [
                            'partij' => $fpartij
                        ]],
                        ['term' => [
                            'jaar' => $fjaar
                        ]],
                    ]
                ]
            ];
        }
        return $getParams;
    }
?>