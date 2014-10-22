<?php
    function searchParamsAdvanced($getParams, $currentpagevalue, $qVraag, $qAntwoord, $qIndiener, $fpartij, $fjaar)
    {
        if ($fpartij == "0" && $fjaar == "0")
        {
            $getParams['body'] = [
                'from' => $currentpagevalue*10,
                'size' => 10,
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



        if ($qVraag != "")
        {
            $getParams['body']['query']['bool']['must'][]['match']['vraag'] = $qVraag;
        }
        if ($qAntwoord != "")
        {
            $getParams['body']['query']['bool']['must'][]['match']['antwoord'] = $qAntwoord;
        }
        if ($qIndiener != "")
        {
            $getParams['body']['query']['bool']['must'][]['match']['indiener'] = $qIndiener;
        }



        return $getParams;
    }
?>