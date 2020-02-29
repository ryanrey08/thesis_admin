<?php

use Illuminate\Database\Seeder;

class CMSTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cms_admin')->insert([
            'page_logo' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAABLAAAASwBAMAAAAZD678AAAAElBMVEX29vYASlU5cXqowMNzmqDT3d/eTyv7AAAgAElEQVR42uydy3baSBRFg0qaG+LMEXHmFjhzZNNzhO3//5VOp/0C85CwStx7au9hr/RaVtV9nHuqJL59AwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADwwPPibrVa3cz+UJbjFyaz2Wr1sPj9vGaBoCPF491q9hZKh5jMVotnFgtaxlSLkPrI7ObhN8sGR4Pq7r5TTH2IrtWCzgh7g2pxblC9dcYVlQu2CXezcS/cPFC44IXHVTnukRmxBX86YL9RRd2C/3iKEFXEFjNgtLD6P7bQ8knq9ftxdGb/sM6pCfYBwuqvBUFHTInIPXCbFaFFWEUSW7csOmFFaEH0QXDy3wWZh8Ufnp+fXzva8/NisVrdz7p59T9piFSrv4fKD79P3ogpHjscWk8eWH9RWrqhXS8q/ImudsVrgvmQqm81uXk48+Jeu9p1jWUqJ67m8W+9PLbotDdIrbS64KyfW6DhdGwhtYS6YD3ggfHJ2JpgPYgwH/r61KnYoh9KlKvyEkd5x88imQ+1y1XUE+LjXuw1/dA1j+UlZ/+jZesnuyPpMQxzenfMPLtGaempq+GushzpiCgtn9xZuXx3OLQYDx22wdrQnc6D/iyeljcObeWl7hgcrFq0QwmT4YLnKXe0Q/+qvba4h8U97dA3udUNPGQ+0A4dt0EbFzgPGLaYpW7jysyV8/1/3g375tJlsCRj9tu22PDGZXvpoNPMkfDeePKxZfvDHwlvlo0bYTzn0rJz2W61w+wtWgyHJrn3NW3NkfB+x0HTsmVf0ULCe4gr69d/953xEFn2s9+BYnkistzFlY/rmfv+8CX7aXh7vMjgfe2QyDJC7npwv8MqtVqvnO9MXhJZPuLKm/4tiCwX+sqfy7jHKyGyzMWVy3OROZFlPa6cbsgTkUVcDSThiSw7ceXZtv6cJEt22Mg05fs45LOEv2WPbcTV2vkD1ZwbWtwGgctMlViquORTXCk81JzIspbc1xqPNdd8LDbA3IN9Z68vufxCbxJveMPCzuJ/V364X+z3UDxpt4sNFvxlyNWbxQYL/hLsnn0IytsNFvzw7BqjkmPTBjtrcKokjJ45dtZlc1l2xefYWZccCIU/dlBhOgwp3BP6iEbNaDiccC9T0rQ1d2gutNTrpNKIbxwNJDv0U3gnshDwwwyECbSGgIAffpWTELM5DvzQfSGR7H3CgR9WuCdzS2mDAz/kAiekYytk1nAtIaXE3Tl0XxIL8YR7WlJjW1wisyIK99uUswqZFU1nJNcNnpBZcchTX9g5blb8RpjkwUaNzIq9qmkexZJbEdhweWRXDUyJir5noiXphczqh5KJ6PNkjOfAepJh9rVF2uNQoBnGmoaWJNl7khEcvTXCX6wGqxEhRxGs247ekvXopRHiN7MgUUo/Cbpbwn+wHj2sIpLiLxtyrd+6j8DaI7OYDL/eCNETLwSaYZ+NcMp6vJJhk/bXCLkncqCS0ww70zBYt0k5ZpqvNEKmn8NrQzPsBlnZspozLndiw9K1TTvmmnNnaor90fVBgHagphG2r+iMzK3JaIRdUo/Z5px5mkZ4uhmyHO2oaITdmiGL1IqcRth1MqSss2JRmiH6nRrfHw36vZNyR5WeUdpZqU7KnUbYWoxS2zsoB66xdUjCNctxlJqzivNkA/r9KBmnq+cuF/q9pR7FwupW4FmvllYDyr2jJKXCt9IMjDld9TuWA6vUYy6W5GKnuo4UPUO/M0ajRKOsGpbDXnKUO8sWOfVQC+cpU0rWcbGAcj93lkaafqbEkTmTDSnZrmCh3MnJ/up5ST3vQ79Tsg6XcxToV+YeStbBgsXM3JnAZaMDNFzvY/3iTsxk3FcrPgu4N+HQCF/VqJSsvRKB1fiy5YBIfaXCaujTcqBkfS5YeKN9WA6ULApWlPTECWRF4uQnJYsFIUFZD+s0ZOiBgrVmNb5CQYruL1iMyZQsChYli4JFyUp7KShYXy9ZJSXrU/GmYPXAhjzdLVhcl+m5ZCWdqAWvElKyKFguKEnVrcJNweq9ZCV8tS2jbsdM1illm4JFyaJgUbL8FCw8rDgTEQWLcOixZKV+IbemYMUuWUm+QpBTsOKXrNsEH7+iYMUvWQkeRQdueAyxtmuyCugG6AA3JSs5xyGjYA0zcU8Te/KSl5+HGbknqT44X2sgcaOUagoWUgNx6bJkpeQ4VNwZis0mRcehoGANuMbjdB66oWCxyPR/2oK/iYXj50GEbCqTd81pzrCj93ceGKIkcBqKo8EcHVpyXKUl3fEaWOkoeYTXQG+I0fkpWMM5Dgmo2YDXcAnHQV++N5ijw5Gnk8XvL4DjNaA7okh3vAaWmxTy7ziIN4iA13ApSXuLdAeGcCqzG8dBWnvkSHeWPGr68NIXTaJHCqT78GwSkLUZ0p1sjlqVOSZEf0QZfZHuF5Hvt6JP2OC60yhigHQnoVOV7uMvgAS5ELUDQ0UysFysvPjYqxlYmfSP9408dHrNwNK2smoPs4lmYElbWcGFmyIaWLnwkUfjImlEA+vdyrqSC6zSRZtXDaxGthcGH8VYNbCC7LFO48NKUQ2s99FJrReWPsxf2cDKRI91cifPJRtYhWgvbJwcsMsG1ruVpXXFwUu+6AZWLtkL3TyVbmB5Ubln1mG1mQQ1QidMHcVemPE6Ib0waiecsr0GeqHOdT9eJ7RAkPvVppwvgZigVuuFFa8T2pK6KnNhgj+cZ5JCbC6kE9IL404jdEJ6IZ2QXkgnhM698JZOCD0yUuqFJZ3QDEGoF9IJ6YV0wnR64RWdEGL0wmuZJ6ET0guj1F46oS1lMlXJkDWbSi/sj4JOaFXz+s70jLuj9MIYVHRCY4j4irxFYbYXTiTS44oNNddEPM/pDe8T2k12zwfRpea3c3wjIE8Cv/ZluRf6bSPY7hYRsIBqOqFBCve9ENvddr67NRex3VEocVXims00OVN57SQltrvtjZk4T4wrttIWzn3rEba7UZyftGE2IFKimg3Y7nbHKtf1dslGWiPzvDcN733RTejjieFY/xbY7h7aydpvG8dssCyA/aV9hdlgGb+nOpgN5D1mA4aDG0aYDaZxe5BbYzbYxqsbxM0GL4aDU4mF2YDIQmKlROGzp9S8RoEKjimxpmwgIguJlRQuncYR5zkM7kgsRBYSC5Ke3HPeVEVkIbEQWe66N1dmTFO5E1lILEQWEitdgjeRhcRyQulMZCGxEFlIrJTJfImsgMRCZMXMAzGJFe7LyQMiy0Dn/iGY3ROtKly5OtMtFSVW8fJUWpHlan4vJCVWJfkCbvB0b05SYr3tgFi+eBrgG8XUbt4DS6rDe7Ica8UNKN8DS6oSj/xYpIXidfcPnVCrF+Z+LNJcObH1SrEfi3SkeN29+hhYUuKxdmOR1oofbag/BpbUd04aN3VA8rtY5cfAkmrybpRLkPxow3gLpSdzM2tlkt/F0g0sNwdwkvaocmB5uTIgaY8qB5aTFiN5Ah3utwPrRunhnFikivbofLzLRGnk9THGZ3L2aFGP9/BTJ7B8iJdKzR7dH1dKkeXDIi3F7NFDcSUUWS7US6E2OB2Mq/H4l0rueJi3cjF7tBof4R+Rh/TQZUZa9ujT+ChLreyZ8jcORDgeVypv7Hi46FQq3R4t6hOBJVKYHegXLe3ejE+ikUD2d01Ku4fTcSUypNhX71LafWcinK0WvxeLVbn9X6dKTzrlLxyw+r6Upt9vk6LebVL76l1Ju28p94eDJoRSDplt7Era/WPBmuwkShB7fdX8vilp9w8K63r9SdeXWiXLunoX0u7hWFxtRZZSFk35+2LTnLDXg9TBjnX1Xuto95Me6ObtHwjcabSuYXS0e3b6ckwl9JEQ4+o96KiO6vTQF5Tku22fKJPR7kUbAdWM9RLJZo40MhmctdFPhVAvHJl+VaGWGZPqVrcXNjq9MDc9iJQqCVy0a3KvX+gW6IXB8jlCIXPIkbW0qBqdMdhyV89lfJ22P4oVxnLN3+KTjGTeVW39ZR+dH3exPHjJHOi0/3ZcJtf9fxjO81uVRW7R02UMB8uHOjJKtmqvN2SsO8OTl86BTtk+Q3IZkWXXK5I50Cm6ZIhMNlVmx8KRSlfIuzxIrdL/7c70lYqnM+oyhIxUJha7TV3mQKfqUoRyNY/FXlOXsXTqTgcIMurd6lCvMxR2Exu1yjmW1XvludpQ2FIrNiqF2qpGlhsKW2ZuxljIUBgjUgJj4TAtei2Sua21okpCWRXJMkNh01GNlyrXk23uYFA727iK9e/NYtOI1DmNrTtWoEblwSuTalFmKHwNrGXHJ/dvZNncwkbm9nfZMW8zFQ2QmfQbZIbCb10bQq4ytQSTL8OUMt+365ohQe3JTdXeQmYoLLo66UHm3cLS4JMEue+BxPsfzI+FluRMJvNOYfc4kfsyyJK/KV5gTRIMrMyg39DIfCQypBtYFk1umXcKzgisUu2DkZYmMB23oTg3sPwXa4PH0Dpuw/kVSyCw7PWdIPfLASm2QoPH0DpuQ9IVy96Br47bkLTGsuc36LgNSVcse36DjtuQtMayd79Bx21IumLZu98g9AtrKWsscwVCyG1Iu2JZu9+Q67gNSWssc0NYpuM2pF2xrG3kSMdtSFtjWWs91VinGyRdsayJ5VrHbUhbYxXGjKxSx21Iu2JZ8xt0fnU7cY1l7AhFycZKvGLZUssyXw5OXmMZM7KUbKzEK5atizNKNlbiGsuWkaVkYyVesWzJZSUbK3GNZcvIUrKxEq9YtvZSycZKXGOZ6j5B6NJM8hWrMuSQStlYiWssU0YWgSVUsSx5kpmSjZW6xrLkkP7L3rlsp67DYJjc5iTAHNPuOSntnLR0nhTO+7/K6QUSJ3G4BJko8v+vM9hr9ZQm9mdJlmQjKj/qusXiFDCncg4VIsbilCEVlR913WJxyh1lkvKjrsdYnDKksSiwXLdYjPyPpDY/52MsRhGzrMS78xarYNOqIis/6nyMxSd5JKp/FBaLz3TKSrw7H2PxcUBeLGpgXbdYfEJmWYl352MsPhlSWYl35y0WnwyprMS78zEWn/lUAEuUxWLjgUR1vCPGYhMzR7IS77BYXHb5AcCSFWNxSb0Lq+jAYnFJvQur6CDG4mIpZHW8w2KxiW0KWRUdxFhcdmPCKjqwWFzyR8IqOoixTu/DBCwpiXdYLC6lFAWwZMVYXHyQsIoOLBaXqFnWGR3EWNU+H1kPWCxS8SgWBsIqOoixmBxiCIVVdGCxmBTppJUKEWMxKRYKO/wFi8UluhF2+AtgcSkWFsJKhSdHcDtYYoIBHhmkVFip8OTbb6gkZML2xTxy3uLASm8e1VRY7YFHFVpaDTq63Q9I60jjMafSatDp7ZGrJ61cygksAYMabfab/csRkvjpbbO/8r/yd5433x8hZ3ENG97IqUGf0jd3SkDWgcNOX9BxVYAFsACWVXFIegtqbgBYJ3Eo0wlqbgBYAAtgiZ9UQc0NAItTfAOwAJbYDQTAsrTV5wDWBGDJA2vIHFIBsOSBxaGcIqhrBmCVUgALYFkEa8jOAkHtWMGqSyU0K1X9s0sSwMoA1iNDjvjfZPIVS+vxZzqrctqxLvvImeb75ZzJAViDKdRZCqQd0GUaOUu7a8YkvzbMStqZHIMKgPVAsGa11Tx1AKx4eLBED7NXWzyFO288IFiRQ2BNTZjJBisffMO0dA6sKcACWHCF/aLKAXMqLoF1zOpkAOsBCl3I6vi6Y4hcWEohwHrkSy51ypx44+3gi3kteZjLtodvkxUoF94YYD1GJ7CSj41yogg9fOjsBlhZu+tqDrAeF9eKVdEGawGwHrETFw6W3wZL9KaQwdbXcyHiKMdZU+7EC08B1oODrLnwFx4crMINsHy3PCEfsBLh4xy55QkZtNmlboDV3BcupL+vAlgPMlnKKYMFsIaJsv5NHAFrNjRYc/EjXR77cuNtBwcrc2aoq5RDkjvzsgDrEWHW6V1zd1bRHGA9Qod3FSefTrwqF7BmEwhgASyIPVgKYAEsgAVdqxRgQZLBWmAqRIKVACwIYEEA66JigCVSBcCCABYEsG4Ea4qpAFiwWBAsFjQoWDHAgmCxIFgsgAWwABZEJw9gQQALAlgAC2ABLAhgQQALYAEsgAUBLAhgASxXxSXzjrYZWCxYLAgWCwJYkECwcK4QgsWCYLFgsQAWwIIIxeXuBlxjBLAAFgSwIIAFCQQLtyZDAAsagfDNFBDAggAWwAJYAAsSGDunAEukuHzDaoKpAFgAC+IPVgGwJIO1AFgQqWImYMWYCoBFKg9gSQZrCrAgmWDlmAtJigYHywdYksFaDg7WGpMhSQHAgmSCFQIsiTpN69bhJ4AAFgSwxuOMIZGhM8ACWAALuhWsfLAniHBXpER5AAuyCdaAj4Cb1ySqAFi2XqiXxAwCg45zcbeCACyABbBsicFxUXEnVgEWwAJYgv2QuIOFAAtgASzBe/1C6JgCLIAFsKjFoZ4i7pgOwOIBlrimd4DFo2cFYAkEi0NfsLjeZIAFsACWYDckroUUYPECazqBxIjDVh8tpALFIjmJFlKAZRMsfJuOILEoAOOL5eQp4wAWvptCLFhz0A3J80L4CgF5YrEhw4Xc4sQjhYTrbQGWVbDWmBAp4lGmwy2k4sSjsQB3+omTzwqsJSZEGljDOiFcvSZOPPZjaG8QJyYZJFShpYlJzhtVaGnKWIGFKrQYMZlRVKGFgjW0D0pRLBQmJk3BqEILE5d9PoqFwsQlM4lioTCFzMDaYkpkiMuEolgoTFxiG5yFFqaCSetmhCOrssQmf4RioSyxyXijpiNLbOYTNR1ZirmAhZqOSLCGj5kLHACTJD67fNR0RIlPXhKpd1Hy2YCF1LtIsIa3E0i9ixKfkBmpd1FitMlH6l2SGKUlkXqXJEazidS7JDHyP0i9CxKniLlAhlSOOO3xPWRI5chnlJVEhlQgWFtGYE0xLeMXp7gGGVJBYrUTQ4ZUjljljhQSWWLEKtudIZElRqy8T4oeUikKWMXL6CEVI147fPSQihGvqUQiS4x4VVECJLKkiFe4HCGRJUXMNvho9ZMiZilJJLKkiJnvQSJLiLhFywXyDTLEbX/voyNLVrZhCdAhG65nDdcMSQ6Woxj5BknZhpjbA6EjS0a2gY+BQCJLhPiVUFI0ziDbYHObusXkjFn80kY+8g2Ssg187APyDcg2IN8AjSbbgHwDsg2W8w05Zme8Chg2bCLfICjbwClS9tDfMH5xnETkG5BtcMY9QwICZeQbkG1w6KGg8RsH5BuQbXAm8IMEbMDGdZ5iv3kDSF3ZBl62IRxPGTp6/QkIn0BSQzyT3MFotoV7hSLBmPZf8UjK0IcYudxRzeBI2t5PLtu6bT3E/7AppPTQ25FwZXllRqNztlyj5FGUoSNVgXVnyi2/vP7H1U/LdQLJgd/vVnG8Wu0+CDMDWUwBVvD6/vP7q93bebDGVd/i2vlE7KIPum15/qD50C+dq74jGLxr7vTj7HCMclOYc3swytBlr+KGngkWUlkMe92p3iN4qD9X8ikFLLbbejrio5fYoPvROhr7p6Pj7vUZ7Ud76gYrHxFXfBufyLaFURabdWeyPNQ+Jeq5NL8MjzXvtI5jAstnWzoh21WkcZeSu4xWptEZ9QutA+NjzSSAxXdXT4V8EJ/R070Ga1bO+6I3m3HyvHn7779on3VPRjS2qhHfPCRVtbA4zt3uY7PZ7d5XjUjrPoM1ryhb9l07z2/NiCvJzbHwmMBSfBvqiLYVacMyRZt3fY84z+8wWCUBfq8R/GXz0xDLL8cPFuNab0aTYUvbrxcdVvG9Nb60ZufTPiMYGFxF1jUdIwMrZHwahshLp0YLsM/OxsrXQTHTDP+0X3zbrCwfi0TrsYPlM+6n82j6UdKOGaly8X3aBopaKBT0mvTUZJoCZX5nZTEQ3ryvVh+0wVDBuNRLZE3TLkcfvd+RdVC1QQt7PaQyLujQvNDtgXVcYQnpp2eM70iIaOK/tNseH3qHWWH9t/xeA9iBysG4mKyBVeX+KT9ecT5lRfNwxZkRC1TPIU3rv+R/9lw46w7eHweWlvtPcm5GgXX0Xpwj80hW0mPc7m5iCTrXTLSZPAqsw6WUv7xNYRUA3he9ew0Egp2BrBunzKeY5eCmwrWyEglH9XQxGbke64MAPgn2fmM+VN1MBH2irJSi6y64ycvbAetUU1opWgOTsu7/DUgcdVgPHcJmYPPVY/dCMmS3tbFbAevPYyVv5TBQRVmK98V5sYWthdd62/TmRF5IE+je5HusrP9MK2q9EP6F0sPy5KpMhmxpwdoaDONNnq2gySirW2KQe6f99ScJujYYrLluZYh8Ycj8uLGN9G0brL8/Y7BAP93oz29mIrY062Z+kw3oHwqfygzPeXPhVqbXp0sPeMwvSPAtbFq9NqeRGd5DV8EnIJqA4gYvfx9Y2nmNj4ap3tb/BE3UkTI/u2fDohrA+h2H1uJ66dyD+0RL0b9hTQd3gFXvzd7W7Mq8MQw0UQfz2L2KAXO7YPkGeF+6z3WlROMf3JDtvgOsoH5EKalN/7YxDEvSeZtwlaKP3k1gRe3o4utMQlpRjZi63mSFF8D6PY6bPDcxfflsni+rXj9ovnVAldHkHrtb8dWeafBUc3V9nUlIR2QjVlzvLsKzsXDZAtRs1Ijj985TQH6LI0Xo43lfbubRR+9GsLLK3b7mk9pdH+2VFxKt6+Z2v9Ox7F+rTv1ktdo1K95B1nXwqDxIkjxr/djaql03h2HG1B5Yit4Ty2BVY+z9/LT8sytTlOXRuebs8qoxnTysb1RDZQ6htPH7O/v4Wr8iTrXGNSUCS7E9oWMxevdMFrooh7v4tiDHaPcnhXU8RL1oDD/V4/iXO1hNp22N8JgiQr9+yO34NtvSmi1awzCnnLUJX9GzfxGs+GimPjWzntSfic6AZhffTpmOQ64N3s70Q7/pyX+7Zrflz7ZWwOIfu1feekoJ1swI1raKp3Uz8ne6YVtbj3QhX3Bx3RjvB6j+/0idO0gdtj89et2VS6hpeT0aGDzWzVi2ntEIVtoCa1YPcmY2YvcqhDrTb16cB6u6P2Cl2ibr3O7AcBaAyGLxj91tRO9GsLImWFre8tcmJDX3QjliLxdslsEkaS9wGp+feLDcHDZ+vOz0sbP2MFCAxT92txG9G819rMdYzWi9aBVCSEcsrYV0BumZqNW39Gvj/uZwvq67zbwGVkeizJBnonENwQhidwv0m8AKWmDlzZ9OdRDWpK+YXSLrOyxa/Tq61jk1v3GzSfOE/plbtYK2LQtpgll/FFf0p9RJXM/gV4tqfRWGkC6rjVJGfabpVCM+f262MA2Cat6Yk9an9Mw9gKH5eD+Bly9G8aUiHjX+nmGoVfUHCkPY6dWmR5Hb+FMY9XRphS1MEejMYP5yLZJIuu3Kuv1pBMY4G8XXIIXUDttrOwe9DlcYIrr6iFsIHq4hywRW1m6P+EvuLi+D5TUpam5Seitm3jNj6TG99mdlWhBXmMyjqs8V/SnMU2fL7CawIlPw6dc+5zxYeSvocCZ2pzesXmsyQj2fUZiig1Qb8sDK8d7LV8Gm7Z/6xhAh02HqBqtoTP0X1R7JG0XsbspYEoP154cW+p9bGn5nbhWsy2WQrD0G5o7PmuNWnU+b1sE6kKUL01HE7tXmNSEEa9o2iWtz0kqbq7z8t5ULCQ4XFpABrI5R0R33tWAd+l/o1JUgWjIHKyBOkXqNxZTWp9MzxXP6zbK2wCr7Y2bXghV0zJ7eSp91Pm2mg3WguxUkGknsTp4irQcmpzuy1jWw8jNGwBpYJVlPV4Lld8ye/rU7aWcQ/dfb+F+uDQKJkfHpW+gsidhn+/rKPLX0LjpyVvozTG2DVZ7f+HcdWEXXk2j+7wJYP01CH6f+P5pwuxhBa4OVXcZflLza7TabnWpfDOUZF5tXjVRgcSN97t6mrDUEWddiSyuj63XGEL9g1b5bgeZ6rGw0XzhLnCINzvfNmcHSDgnbBKu8/CW/BizV5bu0VJ3XGez80pcRfHvZpLWjGMEXmFp4VANYn2aEmnBXv3//0t50RL5Zpx/5n70zaWwUB8Jo25h7cDt34zh3iN13k7jvdpb//1emk+mOWSSxSaDlveNMJ4FSLV+VBDQdS2qS0tlQ+Yu88nrGymxMA0bRm1xj9aMJYscqtYWRjjV4ksm0f5s723bHkr8FaVVpNSRp7cuxFpo+K2RMuBhFsxxUP/KyFEfbLWPq+DhzJNf/fz2rWQwbjhV1OREjfwb165j/d5Q9aBrmODMeNdDAKupgtejVl3XbUoH6hIr8Xv5uGz52cix5Obq7/aOfCiH29eiYzne8OySxdI/cUuWH5RSOdfdtuu3oS1i3icBGymo41qqLY/2QVqWFkdWPtJ/4NYneTYLKx6EvQvF5ERaO+++fvxtv/Vb9uxU41rqbY5WfnU9l/2ppZNfFnfGo/rp9a7E3vyQhl6kGWcXoC1m2RPS7aGl6ZKxFyWcK2d9aGZk15c6MR/WHwVfof77N4Jc0l5+El7D5tt1Isy3ayvqT5LNgjYx1kerybWmlTzKBoV9hu7IDbaJwf23PxBeVoBM71vp72Tbjr+DUuj73zR9qvHQok4bOtuRkdzKZvTG2UpkTjvUj0RkHV3UNEP+dkqZfjJ7+5a238pqIXtjRdKxTa2wspImpMKCE3JJYmkXWQu1YqfB/lx53WY4OyEWrvBE8ttVwrFjmnpWTfktpYsoNJBa3JNZtnLvW9cvue1Wh6kpHo/v0ZbvpmwW5+aFYmXtWXgItfwDMRFuYOrMDXW7ANYmsllfKFsIQL+3pxKMNF/m7jQYAAAz2SURBVLXvpTW/Q5E3fiiVuGda/pexVPGs9GeWyKXxqHaRtRriWD+qLyzbjA/srLV1vWvmoS4iqfYiEPk669dCS4d2oKuzp3tNjtXymNVaWZtyLer9rvWG71scSyKSao9xFdK/VWhPLblDO9Alq2qKsEh951dxxKXVRw/Hi6x1T8dqHm1dCFN4VEvtuTSOltproWsSS6/IavmI5UIsStLqGaf70ZegroVdHEvc8OW1OdJVeruR7oGTexJLr8hSp4ul2DIlx4q0fKdanSy6OJbwVTJRPbMrsmOh/6MfjkksvSIrVfqF5F1l5a84jP+Kbuv7N5rKaNl0o1TyOofm2yLFif5V16OEzkosvZOsQhlTkm+LlJ0pFxvv7bjbdT2J2ZYsmt69lMxML6K+bNup7Maa61binMQqiaxMT2Bd1Oa5V7ZQomr5/RL1bff7eVR7d9b8CYEXPYpUjnokVk0xug4l39bIIYmlVWS1fM1N/D3I8uip+eXMt+ek5wXmypf4CVpTgaKK66EmfBZDPm/454e/w5VYN5H1U48Bsr5VqjLTLKoPLB/LZwc79q2R6oVYsUCpiKR6XjtrWojS+lVhtb+qaJ/pXKKNU46lMRxadpGvQimXlpf1Wjp++nZOE8WXwqT8/0D9RuSH/yeerSBnX0TF59/viMUru1Ss9feAoHw47eNwPO/2YUgsrQV8pf4t4ud0Kkd8o9s7jOsfI7n0DfDmecOoEKY+0T5QevsK/Y+3VKxDldOR0lvkd+eXw/l5lw6VHG5KLJ3xEKtvPpK9FmTdzPqKN/u3X8b3A/7nw0dTrv0UOWImCoKvr0mdd9KkqXKsOBXfx4Du202JpbWCtziAsPms/uWVZDl6yeDKl093+/P5/Hz7fFzzCoRbgwIPFz7f06L1xgSIARU8j8i6jP5VLR+hF27O1iwmSlniQ/RdPavGg7BqZR384tSvC37t9tc71QGHjrsLTDi+hLd801n0xF39EFYzZQ3prOSete7ac7yqH+z+94OXH308a0jSWTp23L0uVHXs6izUdy96U15Dl+VVPxj4LHH8LPGrTHxZgv/81OZXX9euurwnDfnqZpC1a36l8cpXLQKzEDvWpTkSGFgDS7ynHf3qqxpnbX7xWxySmz7X8HvmuJ8afbk2bjG06PteT/Vc8N1PncddT3xsuNb+IousTO0XknKct+mecuIc+HqQlasSS6s6LE5tDU6HvxE/pcNroMK1pPlvKZWGx88vie/O0h/cd7iGz1+x3g++HY291Wwiy3w/Gz93c95YlxXjv9+p3ylXttjYu2pu7ufc2mYXJ3Ah8F1O7h28eFf3DEJg6fLaOB0VnpM7XU0KZ0cl3pM6up9T6zwyVtJSlbJ18vIjty/fY1wP+dThntZrXBcpV4encAwbaGph6LpsXY+MnyymlcMGZysJAwcrSZzXvgtqIcMGowMHhu82VsLM3XtIqYUsitGBQ8Z6WlcJ7324iTsW1Lpgd1n4xgnDd1srodvn5HJqoa0NldvDxSUb0Zax8GNFqIW2UXiygVuwEU2kUwv9Z+lLnx5RC+2sIJk3d0ItpBLq5EottLESur97Sy20CZ/miim10L5K6MOpAGohldAIKw4o29dJnXy4G2ohlZBaSCWkFkLYlZBaSCWkFoZRCX0pHStmpFRCIyTUQgu4fRbDm1vKqYUWsPDvKU9qoVU91Mmfe6IWWlQJfXp6mL7QojXw6X0H1EIqoeG7yljhmWPbr/do5Lx3hkpIvPhI4um7ylLewTYrS18j+8oRh1kpfNUiK0ZZcxIn3laMlFHWjCz81bhXRlk2hLV/Xfltbz1jnecTIh4av2CURbmg4UXgOtiYIN/nimk/W/KcURaWJ26oFe6Q8Nb3mSPa994E+T6PdPe1H18l7ERjdqOhg3yfQ7r7WyiQ77NK9/sA7nHLgk+ubH3eS8uR7/PpD593/5fI9/lMvg0ifJDvE1H4PsSqF3zk+yRESRiHSiLkO9LdbGZGvk9CEsrBXeQ70t0It1EW8n1S6e69pkW+I90N3+sdC2+aPKQnWJDvM+iOEJ65WzJxmF52BGHqlEdXp7Z0GHr2yqOrU9eGMB7lZOIw+awhkAjOmThMwSoJTXOsEp62nzR+T8GJyjUpyxi3gWE4cx0mDswaDMt3hqTmbRySkr2Sspg1mK3/DElN69iwpoUFx7KYNZi9b4akRC6ZmlmDQ9qSlGWAPNjuKMxuePqEFZ51r+zrTJGwwjMuKYuEZTqqHnEFU6b9GXRYsRVtLGEF2XIXpCzT8jXMjnvFVrRp9XoK0wIpW9FmE1aoG7FLUpbZhBVsvJKyjCascMP1FRuQsIwYgZRlMmFdsAIpy0DCesQMpCwDoRr2ThmJ21ik3mMIMjcJi5RFwnKDCFOQsIyQk7JIWKQsV4KUR1Qq1iBl6YpRnlAhZZGwsAcJC4MQoIBFiE9MQng6apMT1hjGiuhUpizelzWQlKmNgCvHZ0ayZGgjorQXwYm/QQYkYbWmLI7PjLMfCUuWsoi4MSKVhFXllZAbQUHC7yISMswxeNRAvle0Ncxhho8aaKpV1jlhjYEygp5ambIwz8DGh4SFAtVHzr5FZwlKzzxs1ICGaEtZ6HesRuzZotyZ03RQC+j3/sqdyXIXK6Hf+8YiwrRbXsdMPRseQlFBihIdai82c7pG4BZz9MnwmKuzficEe2hSZqPdRw50OT2UO6OGFq4Ms4boBhRpa3pPGWah3E2wpBii3I1QoBz6FkJSe1/9jsW6FELEaH/9zji5g5FQ7v31O8WwvRCy+zXEagz+WgshWb0zOWbrXggJvWH6nWLYUgixTw9eiciuIpRZHxrCRCFkIEOyN2KbE/YYrt8phtJCyAgLHWEi5Nh8JuHrorxJz+YzkamLyiSGQoiW0EXBXo7eYkjS/+IVm2guhswcGrFGs6ylGGLGmkEohJo6IGRWVWBRCHUVw+BnDq/EGbnf9KSBAYzGYhi4zEophKaK4QMCi0JopBgGLLNeKYQGlUW406zKBIs+hlA1El4PeAXiwoAgYFasyaqVaH0MPrbWGT6BvtDfGiOwTBk2uIB9RWBNIjFCE/DVhI3AMtcUhWXbKGXgMlU1CKk1rGZrBJZZmRVQa1ggsAhc4wGFwDIts0LxrKoEYIvQfHMUxpTwPUG4m+cpuOitxhJvR5lGx26896zaoIEzWBMJ+A23C0ZKg+chXCRsPc/TJPntWUXCZHQuAe/zvLBAuM9pb289K0+YuBPJxjMzwn3yXslPz6r71YV1N0/kv2fV/IqdnFmGDv55Vs2vaAin4t1vz8KvZqM2zvKrZ3pKGDRYY/wHbg20kPtq/rpfMWiYmMJPz2r4FQ3h3J619+GmnhMGDXNTH5R6UDTiAr+y0rMunt0QJ2XmIUq9CvAIv7JmKRKPlqK+n8CjEzYFubtT6vckYeBus2f99mPMgF9Z51lODrSe8Sv7Pcu9gVZjzIBfWelZm8z1O0C327kua6fifYVfuRPxDgmtpmzHryz2LFeElkBe4VdWe5Ybs1JnLzwURIHvwESrORXFrxzwrP3F8mt+xq8cIHdtlQRlkHN9jrRXNneHosvds4quLJWtw9KocCsMwkaghZPkxcYrPYqu9Dcr6JRn2Ze0hOnKre2C0BBsj9iXtITpinbQboTJwKpVE18h7aCTEt6imZYwXeFXzgqtZG2FNH4TlmraQUfKoXj15hfx0bPFPg/txEIZM3c9jMVuhWx3X2gl6xn7Q7G4sn9HE6pCK5W41i+7roepqC/lcBZF8yZzK8qgg8hqz+SudZS5FZvOXnWH07pWLHcryqCz5fBJuqbrl0k0s2TA4ORTatBFM3/WIeM6/k3hVgxFPdXwxqcPqhpIuvJZwxutiMpkNes8DbSlDuUaJzv9vvVxTpV/kpmoJ7yp1znZH3Tq9WPLX5trRgtT18PPxdak5Fu9ytKj0mCoHn751svHyArY7lVUwfDq4Tjnejs+d/n9VEEv62GHpf9U8+dDn7QS//GpXadfzLmr0F3ry7tefn108anOvxFxhWvdcszufD4cfn38y2Dxx8fb4XA4Hs/n3a7Xb0oeEFeeq/h+rqWJfYblcS3cClxwrTNFMKThw/M0XjXR8Rywh2gC19owYKAiGpBWjEOD5d2Ya+2pgYFXRBNpa4dXwR8hf07xKjCUt3ZUQDAj5Q/PIxPX+oxaB0mfONS5eh6JgACd6+3cb3/58yAEZoOO3nXs4F7rP3nqA2NBbz4OogMyu93+/FI6TAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA8F97cEgAAAAAIOj/a28YAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgLUAt8g9IuvcwyoAAAAASUVORK5CYII=',
            'title' => 'PnC Store',
            'title_color' => '#ffffff',
            'page_color' => '#f4f6f9',
            'menu_color' => '#ffffff',
            'text_menu' => '#7f8386',
            'header_color' => '#3d9970',
            'footer_color' => '#ffffff',
             'footer_content' => '<strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.',
             'footer_text' => '#000',
            'table_color' => '#f4f6f9'
        ]);
    }
}
