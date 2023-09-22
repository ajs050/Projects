const statusRef = document.querySelector(".status")
const videoRef = document.querySelector(".video")


function getSubStatus() {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            resolve("VIPs")
        }, 2000)
    })
}


function getVideo(subStatus) {
    return new Promise ((resolve, reject) => {      
            if (subStatus === "VIP") {
                resolve('Show video')
            }
            else if (subStatus === 'FREE') {
                resolve('Show trailer')
            } else{
                reject('no video')
            }
    })
}

async function main() {
    const status = await getSubStatus()
    statusRef.innerHTML = status
    try {
        console.log(await getVideo(status))
    }
    catch (e) {
        console.log(e)
        videoRef.innerHTML = e
    }
}
main()
